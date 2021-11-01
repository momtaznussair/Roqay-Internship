<?php

namespace App\Http\Livewire\User;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Gloudemans\Shoppingcart\Facades\Cart;

class Products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $categories, $search, $category;

    public function render()
    {
        return view('livewire.user.products', [
            'products' => Product::with('category')
            ->where('name_' . App()->getLocale(), 'LIKE', '%' . $this->search . '%')
            ->when($this->category, function ($query) {
                return $query->where('category_id', $this->category);
            })
            ->paginate(6),
            'cart' => Cart::content()->pluck('id'),
        ]);

        
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function AddToCart($id, $name, $qnt, $price, $cover)
    {
        Cart::add($id, $name, $qnt, $price, 0, ['cover' => $cover]);
        $this->emit('cartUpdated');
    }
}
