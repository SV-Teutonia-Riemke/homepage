<?php

declare(strict_types=1);

namespace App\Business\Shop;

use App\Storage\Entity\Order;
use App\Storage\Entity\OrderItem;
use App\Storage\Entity\Product;

final readonly class OrderFactory
{
    public function create(): Order
    {
        return new Order();
    }

    public function createItem(
        Product $product,
        Order $order,
    ): OrderItem {
        return new OrderItem(
            $product,
            $order,
        );
    }
}
