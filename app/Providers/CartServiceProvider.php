<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind cart service ke container
        $this->app->singleton('cart', function() {
            return new \App\Services\CartService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share cart count ke semua view
        View::composer('*', function($view) {
            $cartCount = array_reduce(Session::get('cart', []), function($carry, $item) {
                return $carry + $item['quantity'];
            }, 0);

            $view->with('cartCount', $cartCount);
        });
    }
}
