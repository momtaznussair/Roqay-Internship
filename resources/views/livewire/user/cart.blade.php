<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <div class="card-body mt-3">
                <!-- Shopping Cart-->
                @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
                <div class="row px-5 justify-content-between">
                    <div class="col-md-7">
                        <div class="shopping-cart" style="height: 68vh; overflow-y:scroll">
                            <div class="row w-100 d-flex justify-content-between">
                                <div class="col-4">
                                    <h5>{{__('My Cart')}}</h5>
                                </div>
                                <div class="col-3">
                                    <button wire:click="clearCart()" class="btn btn-danger">{{__('Empty Cart')}}</button>
                                </div>
                            </div>
                            <hr>
                            {{-- cart items --}}
                            @forelse ($cartItems as $item)
                                <form wire:submit.prevent method="post" class="cart-items mb-2">
                                    <div class="border rounded">
                                        <div class="row bg-white">
                                            <div class="col-md-3 pl-0">
                                                <img src="{{$item->options['cover']}}" style="height: 200px; width:250px" alt="Image1" class="img-fluid">
                                            </div>
                                            <div class="col-md-6 mt-4">
                                                <h5 class="pt-2">{{$item->name}}</h5>
                                                <small class="text-secondary">{{__('seller')}}: Momtaz Nussair</small>
                                                <h5 class="pt-2">{{'$' . $item->price}}</h5>
                                                <button type="submit" class="btn btn-warning">{{__('Save for later')}}</button>
                                                <button wire:click='removeItem("{{$item->rowId}}")' class="btn btn-danger mx-2" name="remove">{{__('Remove')}}</button>
                                            </div>
                                            <div class="col-md-3 py-5">
                                                <div>
                                                    <button wire:click='updateQty("{{$item->rowId}}", "{{$item->qty - 1}}")' type="button" class="btn bg-light border p-2 rounded-pill"><i class="fas fa-minus"></i></button>
                                                    <input type="text" value="{{$item->qty}}" class="form-control  w-25 d-inline">
                                                    <button wire:click='updateQty("{{$item->rowId}}", "{{$item->qty + 1}}")' type="button" class="btn bg-light border p-2  rounded-pill"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @empty
                                <p class="my-5 tx-center text-muted">{{__('Shopping cart is empty')}}</p>
                            @endforelse
                        </div>
                        <a class="btn btn-success" href="{{route('home')}}">{{__('Back to shopping')}}</a>
                    </div>

                    {{-- checkout section - right  --}}
                    <div class="col-md-4 border rounded mt-5 bg-white h-25">

                        <div class="pt-4">
                            <h6>{{__('PRICE DETAILS')}}</h6>
                            <hr>
                            <div class="row price-details mb-3">
                                <div class="col-md-6">
                                    <h6>{{__('Price')}} ({{$cartItems->count()}})</h6>
                                    <h6>{{__('Delivery Charges')}}</h6>
                                    <hr>
                                    <h6>{{__('Amount Payable')}}</h6>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{'$' . $total}}</h6>
                                    <h6 class="text-success">{{__("FREE")}}</h6>
                                    <hr>
                                    <h6>{{'$' . $total}}</h6>
                                </div>
                            </div>
                            <form action="{{route('pay')}}" method="POST">
                                @csrf
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
                                <input type="hidden" name="InvoiceValue" value="{{$total}}">
                                @endforeach
                                <div class="row">
                                    <button type="submit" class="btn btn-warning mt-4 w-100">{{__('Proceed to checkout')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>