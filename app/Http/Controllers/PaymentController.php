<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\PaymentInterface;
use App\Notifications\OrderReceived;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends Controller
{
    public $payment;

    public function __construct(PaymentInterface $payment)
    {
       $this->payment = $payment;
    }

    public function pay(PaymentRequest $request)
    {
        $PaymentURL = $this->payment->executePayment($request->all());
        return redirect($PaymentURL);
    }

    public function callback(Request $request)
    {
        $transactionDetails = $this->payment->getPaymentStatus($request);

        if(!$transactionDetails['paid']){
            return redirect('order-failed');
        }

        //store transaction
        Transaction::create($transactionDetails);
        
        // notify user about the transaction
       User::findOrFail($transactionDetails['user_id'])->notify(new OrderReceived($transactionDetails));

        //clear cart
        Cart::destroy();
        return view('user.payment_success');
    }

    public function errorHandler(Request $request)
    {
       return view('user.payment_failed');
    }
}
