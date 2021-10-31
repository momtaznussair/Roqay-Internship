<?php

namespace App\Services;

use App\Classes\AESDecryption;
use App\Classes\AESEncryption;
use App\Contracts\PaymentInterface;
use Gloudemans\Shoppingcart\Facades\Cart;

class KnetService implements PaymentInterface{

    private $base_url;

    public function __construct()
    {
        $this->base_url = config('knet.baseUrl');
    }


    public function executePayment($data)
    {
         //required data

        // Tranportal ID
        $TranportalId= config('knet.tranportalId');
        $ReqTranportalId="id=".$TranportalId;

        //Tranportal password
        $TranportalPassword=config('knet.tranportalPassword');
        $ReqTranportalPassword="password=".$TranportalPassword;

        //payment amount
        $ReqAmount="amt=". Cart::initial();

        //unique merchant track id
        $TranTrackid=mt_rand();
        $ReqTrackId="trackid=".$TranTrackid;

        // currency KD
        $ReqCurrency="currencycode=414";

        //language [USA, AR]
        $ReqLangid="langid=USA";

        /* Action Code of the transaction, this refers to type of transaction. 
        Action Code 1 stands of Purchase transaction  */
        $ReqAction="action=1";
        // user id
        $ReqUdf1="udf1=" . Auth('web')->id();

         // successful payment url
        $ResponseUrl = config('knet.CallBackUrl');
        $ReqResponseUrl="responseURL=".$ResponseUrl;

        // failed payment url
        $ErrorUrl=config('knet.ErrorUrl');
        $ReqErrorUrl="errorURL=".$ErrorUrl;


        $param=$ReqTranportalId."&".$ReqTranportalPassword."&".$ReqAction."&".$ReqLangid."&".$ReqCurrency."&".$ReqAmount."&".$ReqResponseUrl."&".$ReqErrorUrl."&".$ReqTrackId."&".$ReqUdf1;

        //encrypt request query string
        $termResourceKey= config('knet.termResourceKey');
        $param= AESEncryption::encrypt($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".$ResponseUrl."&errorURL=".$ErrorUrl;

        //payment url
        return $this->base_url . "&trandata=" . $param;
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

}