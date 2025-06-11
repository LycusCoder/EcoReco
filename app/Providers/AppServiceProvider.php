<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Rating;
use App\Observers\RatingObserver;
use Illuminate\Support\Facades\View;
use App\View\Composers\StaffSidebarComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Rating::observe(RatingObserver::class);

    
        // Kode ini bilang ke Laravel:
        // "Setiap kali view 'components.layouts.staff.sidebar' mau ditampilkan,
        // jalankan StaffSidebarComposer dulu dan kasih datanya."
        View::composer('components.layouts.staff.sidebar', StaffSidebarComposer::class);
    }
}