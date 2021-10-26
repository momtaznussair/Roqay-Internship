<?php

namespace App\Http\Livewire\User;

use Gloudemans\Shoppingcart\CartItem;
use Livewire\Component;

use Gloudemans\Shoppingcart\Facades\Cart as CartItems;

class Cart extends Component
{

    protected $listeners = ['cartUpdated' => 'render'];

    public function render()
    {
        return view('livewire.user.cart',[
            'cartItems' => CartItems::content(),
            'total' => CartItems::initial()
        ]);
    }

    public function removeItem($rowId)
    {
        CartItems::remove($rowId);
        $this->emit('cartUpdated');
    }

    public function updateQty($rowId, $qty)
    {
        CartItems::update($rowId, $qty);
        $this->emit('cartUpdated');
    }

    public function clearCart()
    {
        CartItems::destroy();
    }
}
