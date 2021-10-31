<?php 

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

	public function getAll(){
        
		return Product::with('category', 'created_by')->get();
	}

    public function store($data, $images){
		
		$product =  Product::create($data);
		//add images
        foreach ($images as $image) {
            $path = Storage::putFile('products', $image);
            ProductImage::create([
                'image' => $path,
                'product_id' => $product->id
            ]);
        }
	}

    public function update(Product $product, $data, $cover = null, $images = null){
		//change cover
        if($cover)
        {
            Storage::delete($product->cover);
            $newCover = Storage::putFile('products', $cover);
            $data['cover'] = $newCover;
        }

        //update product
        $product->update($data);
        //add images
        if($images)
        foreach ($images as $image) {
            $path = Storage::putFile('products', $image);
            ProductImage::create([
                'image' => $path,
                'product_id' => $product->id
            ]);
        }
	}

    public function delete(Product $product){
		 //delete images
         $images = $product->images;
         foreach ($images as $image) {
             Storage::delete($image->image);
         }
         //delete cover 
         Storage::delete($product->cover);
         // delete product
         $product->delete();		
	}

    public function deleteImage(ProductImage $image){

        Storage::delete($image->image);
        $image->delete();
	}


}