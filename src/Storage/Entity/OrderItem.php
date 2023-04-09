<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Product $product;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Order $order;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $additionalInformation;

    public function __construct(
        Product $product,
        Order $order,
        string|null $additionalInformation = null,
    ) {
        $this->product               = $product;
        $this->order                 = $order;
        $this->additionalInformation = $additionalInformation;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    public function getAdditionalInformation(): string|null
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string|null $additionalInformation): void
    {
        $this->additionalInformation = $additionalInformation;
    }

    public function getTotal(): Money
    {
        return $this->getProduct()->getPrice();
    }
}
