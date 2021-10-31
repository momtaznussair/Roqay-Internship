<?php

use App\Classes\PaymentMethod;

return [

    'base_url' => env('MYFATOORAH_BASE_URL'),

    'token' => env('MYFATOORAH_TOKEN'),

    'available_payment_methods' => collect([

        new PaymentMethod(1, 'كي نت', 'KNET', 'https://demo.myfatoorah.com/imgs/payment-methods/kn.png'),
        new PaymentMethod(2, 'فيزا / ماستر', 'VISA/MASTER', 'https://demo.myfatoorah.com/imgs/payment-methods/vm.png'),
    ]),

    'CallBackUrl' => 'http://www.momtaznussair.com/order-received',

    'ErrorUrl' => 'http://www.momtaznussair.com/order-failed'
];