<?php
namespace App\Modules\Client\Providers;

use App\Modules\Client\Classes\ViewVars;
use Illuminate\Support\ServiceProvider;

class VarsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('view-vars', function ($app) {
            return new ViewVars();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return ['view-vars'];
    }

}
