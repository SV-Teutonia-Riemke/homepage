<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\ConfigSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigSettingRepository::class)]
class ConfigSetting extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private mixed $value;

    public function __construct(
        string $name,
        mixed $value = null,
    ) {
        $this->name  = $name;
        $this->value = $value;
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
