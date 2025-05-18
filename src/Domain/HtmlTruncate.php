<?php

declare(strict_types=1);

namespace App\Domain;

use DOMDocument;
use DOMElement;
use DOMLettersIterator;
use DOMNode;
use DOMText;
use RuntimeException;

use function in_array;
use function mb_convert_encoding;
use function rtrim;
use function substr;

final class HtmlTruncate
{
    private string|null $truncatedHtml = null;

    /** @param int<0,max> $maxLength */
    public function __construct(
        public readonly string $originalHtml,
        public readonly int $maxLength,
        private readonly string|null $ellipsis = '...',
    ) {
    }

    public function getTruncatedHtml(): string
    {
        if ($this->truncatedHtml === null) {
            $this->truncatedHtml = $this->truncateHtml($this->originalHtml);
        }

        return $this->truncatedHtml;
    }

    public function isTruncated(): bool
    {
        $truncatedHtml = $this->getTruncatedHtml();
        $originalHtml  = $this->htmlToDomDocument($this->originalHtml);

        return $truncatedHtml !== $originalHtml->saveHTML();
    }

    private function truncateHtml(string $html): string
    {
        $dom = $this->htmlToDomDocument($html);

        // Grab the body of our DOM.
        $body = $dom->getElementsByTagName('body')->item(0);

        if ($body !== null) {
            // Iterate over letters.
            $letters = new DOMLettersIterator($body);
            foreach ($letters as $letter) {
                // If we have exceeded the limit, we want to delete the remainder of this document.
                if ($letters->key() < $this->maxLength) {
                    continue;
                }

                $currentText               = $letters->currentTextPosition();
                $currentText[0]->nodeValue = substr($currentText[0]->nodeValue, 0, $currentText[1] + 1);

                $this->removeProceedingNodes($currentText[0], $body);

                if ($this->ellipsis !== null && $this->ellipsis !== '') {
                    $this->insertEllipsis($currentText[0], $this->ellipsis);
                }

                break;
            }
        }

        $savedHtml = $dom->saveHTML();

        return $savedHtml === false ? '' : $savedHtml;
    }

    private function htmlToDomDocument(string $html): DOMDocument
    {
        // Transform multibyte entities which otherwise display incorrectly.
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        if ($html === false) {
            throw new RuntimeException('Unable to convert html to dom document', 1747572074616);
        }

        // Instantiate new DOMDocument object, and then load in UTF-8 HTML.
        $dom           = new DOMDocument();
        $dom->encoding = 'UTF-8';
        $dom->loadHTML($html);

        return $dom;
    }

    private function removeProceedingNodes(
        DOMNode|DOMElement $domNode,
        DOMNode|DOMElement $topNode,
    ): void {
        $nextNode = $domNode->nextSibling;

        if ($nextNode !== null) {
            self::removeProceedingNodes($nextNode, $topNode);

            $domNode->parentNode?->removeChild($nextNode);
        } else {
            //scan upwards till we find a sibling
            $curNode = $domNode->parentNode;
            while ($curNode !== null && $curNode !== $topNode) {
                if ($curNode->nextSibling !== null) {
                    $curNode = $curNode->nextSibling;

                    self::removeProceedingNodes($curNode, $topNode);

                    $curNode->parentNode?->removeChild($curNode);

                    break;
                }

                $curNode = $curNode->parentNode;
            }
        }
    }

    private function insertEllipsis(
        DOMNode|DOMElement $domNode,
        string $ellipsis,
    ): void {
        $avoid = ['a', 'strong', 'em', 'h1', 'h2', 'h3', 'h4', 'h5']; //html tags to avoid appending the ellipsis to

        if ($domNode->parentNode?->parentNode !== null && in_array($domNode->parentNode->nodeName, $avoid, true)) {
            // Append as text node to parent instead
            $textNode = new DOMText($ellipsis);

            if ($domNode->parentNode->parentNode->nextSibling !== null) {
                $domNode->parentNode->parentNode->insertBefore($textNode, $domNode->parentNode->parentNode->nextSibling);
            } else {
                $domNode->parentNode->parentNode->appendChild($textNode);
            }
        } else {
            $domNode->nodeValue = rtrim($domNode->nodeValue ?? '') . $ellipsis;
        }
    }
}
