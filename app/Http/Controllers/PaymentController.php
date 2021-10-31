<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\PaymentInterface;
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

        //store transaction
        Transaction::create($transactionDetails);
        //clear cart
        Cart::destroy();
        //loggin user 
        // $user = User::findOrfail($transactionDetails['user_id']);
        // Auth('web')->login($user);
        return view('user.payment_success');
    }

    public function errorHandler(Request $request)
    {
       return view('user.payment_failed');
    }
}
