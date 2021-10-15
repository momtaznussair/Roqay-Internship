<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules =  User::rules();
        
        if($this->getMethod() !== 'POST')
        {
            $rules['email'] = 'required|email|max:255|unique:users,email,'. $this->user->id;
            $rules['phones.*'] = ['required', 'digits:11', 'numeric', 'distinct', Rule::unique('phones', 'number')->ignore($this->user->id, 'user_id')];
            $rules['password'] = 'nullable|confirmed|min:8';
            $rules['avatar'] = 'nullable|image|mimes:png,jpg|max:512';
            
        }

        return $rules;
    }
}
