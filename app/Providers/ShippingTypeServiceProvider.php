<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ShippingServiceInterface;
use App\Services\UshipService;
use App\Services\UpsService;
use App\Services\FedexService;

class ShippingTypeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("App\Contracts\ShippingServiceInterface", function($app){
            $shipping_Type = $this->app->request->thirdParty;
            if ( $shipping_Type == "uship" ) {
                return new UshipService();
            } else if ($shipping_Type == "UPS" ){
                return new UpsService();
            } else {
                return new FedexService();
            }
        });
    }
}
