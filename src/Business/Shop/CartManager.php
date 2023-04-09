<?php

declare(strict_types=1);

namespace App\Business\Shop;

use App\Storage\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CartManager
{
    public function __construct(
        private CartSessionStorage $cartSessionStorage,
        private OrderFactory $orderFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function getCurrent(): Order
    {
        $order = $this->cartSessionStorage->getOrder();

        if ($order === null) {
            $order = $this->orderFactory->create();
        }

        return $order;
    }

    public function save(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->cartSessionStorage->setOrder($order);
    }
}
