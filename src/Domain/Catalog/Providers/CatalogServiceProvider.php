<?php

declare(strict_types=1);

namespace Domain\Catalog\Providers;

use Illuminate\Support\ServiceProvider;
class CatalogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }
}
