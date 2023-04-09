<?php

declare(strict_types=1);

namespace App\Business\Shop;

use App\Storage\Entity\Order;
use App\Storage\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final readonly class CartSessionStorage
{
    private const CART_KEY_NAME = 'cart_id';

    public function __construct(
        private RequestStack $requestStack,
        private OrderRepository $orderRepository,
    ) {
    }

    public function getOrder(): Order|null
    {
        return $this->orderRepository->findOneBy([
            'id'     => $this->getCartId(),
            'status' => OrderStatus::CART,
        ]);
    }

    public function setOrder(Order $cart): void
    {
        $this->getSession()->set(self::CART_KEY_NAME, $cart->getId());
    }

    private function getCartId(): int|null
    {
        return $this->getSession()->get(self::CART_KEY_NAME);
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
