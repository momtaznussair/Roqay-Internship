<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',   
        'status',
    ];

    public static function rules()
    {
        return [
           'name' =>'required|string|max:255',
           'email' => 'required|email|max:255|unique:admins,email',
           'password' => 'required|confirmed',
           'avatar' =>  'nullable|image|mimes:png,jpg|max:512',
           'status'=> 'required|in:active,suspended',
           'roles' => 'required|exists:roles,id',
        ];
    }
}
