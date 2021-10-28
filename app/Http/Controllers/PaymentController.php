<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Contracts\PaymentInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;
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
        $response = $this->payment->executePayment($request->all());
        return redirect($response['PaymentURL']);
    }

    public function callback(Request $request)
    {
        $data = [
            'Key' => $request->paymentId,
            'KeyType' => 'PaymentId',
        ];

        $response = $this->payment->getPaymentStatus($data);

        //store transaction
        Transaction::create([
            'user_id' => Auth('web')->id(),
            'InvoiceId' => $response['InvoiceId'],
            'InvoiceValue' => $response['InvoiceValue'],
        ]);
        //clear cart
        Cart::destroy();

        return view('user.payment_success');
    }
}
