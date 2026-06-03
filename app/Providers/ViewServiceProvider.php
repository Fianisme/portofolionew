<?php

namespace App\Providers;

use App\Http\View\Composers\NavbarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.navbar', NavbarComposer::class);
    }
}
