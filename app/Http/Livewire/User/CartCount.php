<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartCount extends Component
{

    protected $listeners = ['cartUpdated' => 'render'];
    public function render()
    {
        return view('livewire.user.cart-count',[
            'cart_count' => count(Cart::content())
        ]);
        
    }
}
