<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Faq;
use App\Models\Contact;
use App\Models\Kategori;

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
        // Set custom pagination views
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.simple-custom');

        // Bagikan semua FAQ ke semua view
        View::composer('*', function ($view) {
            $view->with('faqs', Faq::all());
        });

        // Bagikan data kontak ke semua view langsung dari model
        View::composer('*', function ($view) {
            $view->with('contact_view', Contact::first());
        });

        View::composer('*', function ($view) {
            $view->with('category', Kategori::all());
        });
    }
}
