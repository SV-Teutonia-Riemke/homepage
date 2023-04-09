<?php

declare(strict_types=1);

namespace App\Business\Shop;

enum OrderStatus: string
{
    case CART = 'cart';
}
