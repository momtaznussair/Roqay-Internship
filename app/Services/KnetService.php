<?php

namespace App\Services;

use Arr;
use Illuminate\Support\Str;
use App\Classes\AESDecryption;
use App\Classes\AESEncryption;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\App;
use Gloudemans\Shoppingcart\Facades\Cart;

class KnetService implements PaymentInterface{

    private $base_url;

    public function __construct()
    {
        $this->base_url = config('knet.baseUrl');
    }


    public function executePayment($data)
    {
         //required request data
         $data = [
             'id' => config('knet.tranportalId'),
             'password' => config('knet.tranportalPassword'),
             'action' => 1, // Action Code 1 stands of Purchase transaction
             'langid' => App::isLocale('ar') ? 'AR' : 'USA',
             'currencycode' => 414, // KD
             'amt' => Cart::initial(),
             'responseURL' => config('knet.CallBackUrl'),
             'errorURL' => config('knet.ErrorUrl'),
             'trackid' => Str::random(13), //unique merchant tracking id
             'udf1' => Auth('web')->id(), //user id
         ];

        $requestParams = [

            'param' => 'paymentInit',
            'trandata' => $this->prepareTransData($data),
            'tranportalId' => $data['id'],
            'responseURL' => $data['responseURL'],
            'errorURL' => $data['errorURL']
        ];

        $requestParamsAsqueryString = Arr::query($requestParams);
        //payment url
        return $this->base_url .  $requestParamsAsqueryString;
        
    }

    public function getPaymentStatus($request)
    {
        // decrypt response
        $decryptedRespons = AESDecryption::decrypt($request->trandata);

        parse_str($decryptedRespons, $response_as_array);

        $transactionDetails = [
            'user_id' => $response_as_array['udf1'],
            'InvoiceId' => $response_as_array['paymentid'],
            'InvoiceValue' => $response_as_array['amt']
        ];

        return $transactionDetails;
    }

    /**
     * takes $data as an array and format it as query string then encrypt it using AES helper encrypt method
     * 
     * @param $data 
     */
    private function prepareTransData(Array $data) : string
    {
        $dataAsQueryString = Arr::query($data);

        //decode urls before encryping $data "Arr::query encode ulrs according to some RFC standard"
        $dataAsQueryString = urldecode($dataAsQueryString);

        return AESEncryption::encrypt($dataAsQueryString);
    }

}