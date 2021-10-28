<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'img',
    ];

    protected $appends  = ['name', 'image'];

    public function getNameAttribute()
    {
        return $this->{ 'name_' . app()->currentLocale() };
    }

    public function getImageAttribute()
    {
        return asset("storage/".$this->img);
    }

    public function posts()
    {
       return $this->hasMany(Post::class);
    }
}
