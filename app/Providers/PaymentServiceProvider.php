<?php

namespace App\Providers;

use App\Contracts\PaymentInterface;
use App\Services\KnetService;
use App\Services\MyFatoorahService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $availablePaymentServices = [
            'myfatoorah' => MyFatoorahService::class,
            'knet' => KnetService::class
        ];
        
        // $this->app->bind(PaymentInterface::class, $availablePaymentServices[env('PAYMENT_SERVICE')]);
        $this->app->bind(PaymentInterface::class, $availablePaymentServices['knet']);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
