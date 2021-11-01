<?php

use App\Helpers\PaymentMethod;

return [

    'base_url' => env('MYFATOORAH_BASE_URL'),

    'token' => env('MYFATOORAH_TOKEN'),

    'available_payment_methods' => collect([

        new PaymentMethod(1, 'كي نت', 'KNET', 'https://demo.myfatoorah.com/imgs/payment-methods/kn.png'),
        new PaymentMethod(2, 'فيزا / ماستر', 'VISA/MASTER', 'https://demo.myfatoorah.com/imgs/payment-methods/vm.png'),
    ]),

    'CallBackUrl' => env('PAYMENT_CALLBACK_URL'),

    'ErrorUrl' => env('PAYMENT_ERROR_URL')
];