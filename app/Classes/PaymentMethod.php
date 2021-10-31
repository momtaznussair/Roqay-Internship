<?php 
namespace App\Classes;

class PaymentMethod {

    public $PaymentMethodId;
    public $PaymentMethod_ar;
    public $PaymentMethod_en;
    public $image;

    public function __construct($PaymentMethodId, $PaymentMethod_ar, $PaymentMethod_en, $image)
    {
        $this->PaymentMethodId = $PaymentMethodId;
        $this->PaymentMethod_ar = $PaymentMethod_ar;
        $this->PaymentMethod_en = $PaymentMethod_en;
        $this->image = $image;
    }
}