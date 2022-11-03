<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

final class ConfigItem
{
    /** @param array<string, mixed> $formOptions */
    public function __construct(
        public readonly string $name,
        public readonly string $formType,
        public readonly array $formOptions = [],
        public readonly mixed $default = null,
    ) {
    }

    public function getLabel(): TranslatableMessage
    {
        return new TranslatableMessage(sprintf('item_%s', $this->name), [], 'config');
    }
}
