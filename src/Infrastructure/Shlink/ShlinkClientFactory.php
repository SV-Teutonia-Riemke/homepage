<?php

declare(strict_types=1);

namespace App\Infrastructure\Shlink;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Shlinkio\Shlink\SDK\Config\ShlinkConfig;
use Shlinkio\Shlink\SDK\Domains\DomainsClient;
use Shlinkio\Shlink\SDK\Http\HttpClient;
use Shlinkio\Shlink\SDK\RedirectRules\RedirectRulesClient;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\ShortUrlsClient;
use Shlinkio\Shlink\SDK\Tags\TagsClient;
use Shlinkio\Shlink\SDK\Visits\VisitsClient;

class ShlinkClientFactory
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
    ) {
    }

    public function __invoke(): ShlinkClient
    {
        $config = ShlinkConfig::fromArray([
            'baseUrl' => ' https://svtr.link',
            'apiKey' => '4fd14c2c-8c67-463b-8e02-a3c8c47d7524',
            'version' => '3',
        ]);

        $httpClient = new HttpClient(
            $this->httpClient,
            $this->requestFactory,
            $this->streamFactory,
            $config,
        );

        $shortUrlsClient     = new ShortUrlsClient($httpClient);
        $visitsClient        = new VisitsClient($httpClient);
        $tagsClient          = new TagsClient($httpClient);
        $domainsClient       = new DomainsClient($httpClient);
        $redirectRulesClient = new RedirectRulesClient($httpClient);

        return new ShlinkClient(
            $shortUrlsClient,
            $visitsClient,
            $tagsClient,
            $domainsClient,
            $redirectRulesClient,
        );
    }
}
