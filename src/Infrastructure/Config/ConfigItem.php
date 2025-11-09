<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

final readonly class ConfigItem
{
    /** @param array<string, mixed> $formOptions */
    public function __construct(
        public string $name,
        public string $formType,
        public array $formOptions = [],
        public mixed $default = null,
    ) {
    }

    public function getLabel(): TranslatableMessage
    {
        return new TranslatableMessage(sprintf('item_%s', $this->name), [], 'config');
    }
}
