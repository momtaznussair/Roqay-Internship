<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Arr;
use App\Models\ProductImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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

    public function render()
    {
        $this->products = Product::with('category', 'created_by')->get();
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

    public function store()
    {
        $validatedDate = $this->validate($this->rules);
        // storing cover
        $cover = Storage::putFile('products', $this->cover);

        $validatedDate['admin_id'] = Auth('admin')->user()->id;
        $validatedDate['cover'] = $cover;
        //create product
        $product =  Product::create($validatedDate);

        //add images
        foreach ($this->images as $image) {
            $path = Storage::putFile('products', $image);
            ProductImage::create([
                'image' => $path,
                'product_id' => $product->id
            ]);
        }

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

    public function update()
    {
         //update validation rules
        $this->rules['newCover'] = 'nullable|image|mimes:png,jpg,jpeg';
        $this->rules['images'] = 'nullable|array';

        $validatedDate = $this->validate(Arr::except($this->rules, ['cover']));
        //change cover
        if($this->newCover)
        {
            Storage::delete($this->product->cover);
            $cover = Storage::putFile('products', $this->newCover);
            $validatedDate['cover'] = $cover;
        }

        //update product
        $this->product->update($validatedDate);
        //add images
        if($this->images)
        foreach ($this->images as $image) {
            $path = Storage::putFile('products', $image);
            ProductImage::create([
                'image' => $path,
                'product_id' => $this->product->id
            ]);
        }

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

    public function delete()
    {
        //delete images
        $images = $this->product->images;
        foreach ($images as $image) {
            Storage::delete($image->image);
        }
        //delete cover 
        Storage::delete($this->product->cover);
        // delete product
        $this->product->delete();
        $this->emit('hideModal'); // Close model to using jquery
        $this->emit('success', __('Product Deleted Successfully'));
        $this->resetInputFields();
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::delete($image->image);
        $imageButtonId = $image->id;
        $image->delete();
        $this->emit('success', __("Image Deleted Successfully"), $imageButtonId);
    }
}
