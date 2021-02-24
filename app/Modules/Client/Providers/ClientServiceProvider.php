<?php
namespace App\Modules\Client\Providers;

use App\Modules\Client\Classes\ClientFacade;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider {

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
        $this->app->singleton('client', function ($app) {
            return new ClientFacade();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return ['client'];
    }

}
