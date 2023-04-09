<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Business\Shop\OrderStatus;
use App\Storage\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
class Order extends AbstractEntity
{
    /** @var Collection<int, OrderItem> */
    #[ORM\OneToMany(mappedBy: 'order', targetEntity: OrderItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(type: Types::STRING, enumType: OrderStatus::class)]
    private OrderStatus $status;

    public function __construct(
        OrderStatus $status = OrderStatus::CART,
    ) {
        $this->status = $status;
        $this->items  = new ArrayCollection();
    }

    /** @return Collection<int, OrderItem> */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): void
    {
        if ($this->items->contains($item)) {
            return;
        }

        $item->setOrder($this);
        $this->items->add($item);
    }

    public function removeItem(OrderItem $item): void
    {
        if (! $this->items->contains($item)) {
            return;
        }

        $this->items->removeElement($item);
    }

    public function clearItems(): void
    {
        foreach ($this->items as $item) {
            $this->items->removeElement($item);
        }
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function setStatus(OrderStatus $status): void
    {
        $this->status = $status;
    }

    public function getTotal(): Money
    {
        $total = new Money(0, new Currency('EUR'));

        foreach ($this->items as $item) {
            $total->add($item->getTotal());
        }

        return $total;
    }
}
