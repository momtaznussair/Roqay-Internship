<?php

namespace App\Contracts;

interface PaymentInterface{

    /**
     * make an execute payment call
     * @param $data
     */
    public function executePayment($data);

    /**
     * get payment status
     * @param $data
     */
    public function getPaymentStatus($data);

}