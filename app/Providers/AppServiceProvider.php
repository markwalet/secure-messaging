<?php

namespace App\Providers;

use App\Support\PasteBinClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Config\Repository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PasteBinClient::class, function (Application $app) {
            /** @var Repository $config */
            $config = $app['config'];

            return new PasteBinClient($config->get('services.pastebin', []));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(app()->isProduction() === false);
    }
}
