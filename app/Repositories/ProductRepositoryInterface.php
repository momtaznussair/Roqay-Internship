<?php 

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;

interface ProductRepositoryInterface{
	
	public function getAll();
	public function store($data, $images);
	public function update(Product $product, $data, $cover = null, $images = null);
	public function delete(Product $product);
	public function deleteImage(ProductImage $image);

}