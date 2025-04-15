<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService
{
    public function count()
    {
        return array_reduce(Session::get('cart', []), function($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    public function items()
    {
        return Session::get('cart', []);
    }

}
