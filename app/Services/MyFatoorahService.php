<?php

namespace App\Services;

use App\Contracts\PaymentInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MyFatoorahService implements PaymentInterface{

    private $base_url;
    private $headers;

    public function __construct()
    {
        $this->base_url = config('myfatoorah.base_url');

        $this->headers = [
            'content-type' => 'application/json',
            'authorization' => 'Bearer ' . config('myfatoorah.token') //myfatoorah secret token
        ];
    }
    

    function executePayment($data) {
        $body = [
            //Fill required data
            'paymentMethodId' => $data['paymentMethodId'],
            'InvoiceValue'    => Cart::initial(),
            'CustomerName'    => Auth('web')->user()->name,
            'CustomerEmail'   => Auth('web')->user()->email,
            'CallBackUrl'     => config('myfatoorah.CallBackUrl'),
            'ErrorUrl'        => config('myfatoorah.ErrorUrl'),
            'Language'    =>  App::currentLocale(),
        ];

        $PaymentURL = Http::withHeaders($this->headers)
        ->post("$this->base_url/v2/ExecutePayment", $body)['Data']['PaymentURL'];

        return $PaymentURL;
    }

    public function getPaymentStatus($request){

        $data = [
            'Key' => $request->paymentId,
            'KeyType' => 'PaymentId',
        ];

        $response = Http::withHeaders($this->headers)
        ->post("$this->base_url/v2/getPaymentStatus", $data)['Data'];

        dd($response);
    }   

}


