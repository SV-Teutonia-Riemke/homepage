<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\ConfigSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigSettingRepository::class)]
class ConfigSetting extends AbstractEntity
{
    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
        #[ORM\Column(type: Types::TEXT, nullable: true)]
        private mixed $value = null,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
