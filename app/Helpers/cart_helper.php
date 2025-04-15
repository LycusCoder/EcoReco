<?php

use Illuminate\Support\Facades\Session;

if (!function_exists('cart_count')) {
    function cart_count()
    {
        $cart = Session::get('cart', []);
        return array_reduce($cart, function($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }
}
