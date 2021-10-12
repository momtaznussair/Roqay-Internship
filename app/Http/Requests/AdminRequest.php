<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  Admin::rules();
        
        if($this->getMethod() !== 'POST')
        {
            $rules['email'] = 'required|email|max:255|unique:admins,email,'.$this->admin->id;
            $rules['password'] = 'nullable|confirmed';
        }

        return $rules;
    }
}
