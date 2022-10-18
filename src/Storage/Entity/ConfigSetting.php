<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\ConfigType;
use App\Storage\Repository\ConfigSettingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfigSettingRepository::class)]
class ConfigSetting extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING, enumType: ConfigType::class)]
    private ConfigType $type;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $value;

    public function __construct(
        string $name,
        ConfigType $type,
        string|null $value = null,
    ) {
        $this->name  = $name;
        $this->type  = $type;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ConfigType
    {
        return $this->type;
    }

    public function setValue(string|null $value): void
    {
        $this->value = $value;
    }

    public function getValue(): string|null
    {
        return $this->value;
    }
}
