<?php

namespace App\Providers;

use App\Services\GetPrefix;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class SidebarComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.layouts.sidebar',GetPrefix::class);
    }
}
