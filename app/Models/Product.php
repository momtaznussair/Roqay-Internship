<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'cover',
        'price',
        'category_id',
        'admin_id',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function created_by()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    protected $appends  = ['name', 'description'];

    public function getNameAttribute()
    {
        return $this->{ 'name_' . app()->currentLocale() };
    }

    public function getDescriptionAttribute()
    {
        return $this->{ 'description_' . app()->currentLocale() };
    }
}
