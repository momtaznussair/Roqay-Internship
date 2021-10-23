<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Arr;
use App\Models\ProductImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ProductRepositoryInterface;

class ProductComponent extends Component
{
    use WithFileUploads;

    public $products, $name_ar, $name_en, $description_ar, 
    $description_en, $price, $cover, $images, $category_id, $name, $product, $newCover;

    public $updateMode;
    public $categories = [];

    protected $rules = [
        'name_ar' => 'required|string|max:255|min:3',
        'name_en' => 'required|string|max:255|min:3',
        'description_ar' => 'required|string|max:512|min:20',
        'description_en' => 'required|string|max:512|min:20',
        'price' => 'required|numeric|max:999999.99|min:0',
        'cover' => 'required|image|mimes:png,jpg,jpeg',
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpg,jpeg,png',
        'category_id' => 'required|exists:categories,id'
    ];

    //realtime validation
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function render(ProductRepositoryInterface $repository)
    {
        $this->products = $repository->getAll();
        return view('livewire.product-component');
    }

    private function resetInputFields(){
        $this->reset('name_ar', 'name_en', 'description_ar', 'description_en', 'price', 
        'cover', 'images', 'product', 'rules', 'newCover');
    }

    public function getCategories()
    {
        $this->categories = Category::all();
    }

    public function store(ProductRepositoryInterface $repository)
    {
        $validatedDate = $this->validate($this->rules);
        // storing cover
        $cover = Storage::putFile('products', $this->cover);

        $validatedDate['admin_id'] = Auth('admin')->user()->id;
        $validatedDate['cover'] = $cover;

        //using product repository for storing a product
        $repository->store($validatedDate, $this->images);

        $this->resetInputFields();

        $this->emit('hideModal'); // Close model to using jquery
        $this->emit('success', __('Product Created Successfully'));

    }

    public function edit($id)
    {
        //find product and set properties to it
        $product = Product::findOrFail($id);
        $this->product = $product;
        $this->name_ar = $product->name_ar;
        $this->name_en = $product->name_en;
        $this->description_en = $product->description_en;
        $this->description_ar = $product->description_ar;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->cover = $product->cover;
        $this->getCategories();
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function update(ProductRepositoryInterface $repository)
    {
        //update validation rules
        $this->rules['newCover'] = 'nullable|image|mimes:png,jpg,jpeg';
        $this->rules['images'] = 'nullable|array';

        $validatedDate = $this->validate(Arr::except($this->rules, ['cover']));
        
        $repository->update($this->product, $validatedDate, $this->newCover, $this->images);

        $this->emit('hideModal'); // Close model to using jquery
        $this->emit('success', __('Product Updated Successfully'));
        $this->resetInputFields();
    }



    //delete products and images

    public function  setDeletedProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->product = $product;
    }

    public function delete(ProductRepositoryInterface $repository)
    {
        $repository->delete($this->product);
        
        $this->emit('hideModal'); // Close model to using jquery
        $this->emit('success', __('Product Deleted Successfully'));
        $this->resetInputFields();
    }

    public function deleteImage(ProductRepositoryInterface $repository, ProductImage $image)
    {
        $imageButtonId = $image->id;
        $repository->deleteImage($image);
        $this->emit('success', __("Image Deleted Successfully"), $imageButtonId);
    }
}
