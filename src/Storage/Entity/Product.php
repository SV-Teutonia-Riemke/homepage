<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use Tbbc\MoneyBundle\Type\MoneyType;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $articleNumber;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $description;

    #[ORM\Column(type: MoneyType::NAME)]
    private Money $price;

    public function __construct(
        string $articleNumber,
        string $name,
        string|null $description,
        Money $price,
    ) {
        $this->articleNumber = $articleNumber;
        $this->name          = $name;
        $this->description   = $description;
        $this->price         = $price;
    }

    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    public function setArticleNumber(string $articleNumber): void
    {
        $this->articleNumber = $articleNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function setDescription(string|null $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }
}
