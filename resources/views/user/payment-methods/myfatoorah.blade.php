@foreach (config('myfatoorah.available_payment_methods') as $payment_method)
<div class="form-check mb-2">
    <label class="form-check-label mr-3" for="{{$payment_method->PaymentMethodId}}">
        <img src="{{$payment_method->image}}" style="width: 2.5rem;" class="mr-4">
    </label>
    <input class="form-check-input" name="paymentMethodId" type="radio" value="{{$payment_method->PaymentMethodId}}" id="{{$payment_method->PaymentMethodId}}" required>
    <label class="form-check-label mr-3" for="{{$payment_method->PaymentMethodId}}">
        {{ $payment_method->{'PaymentMethod_' . App::currentLocale()} }}
    </label>
</div>
@endforeach