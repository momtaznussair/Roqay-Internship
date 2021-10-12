<?php

namespace App\Http\Requests;

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
        $rules = $this->rules();

        if(!$this->getMethod() == 'POST')
        {
            $rules['emain'] = 'required|email|max:255|unique:admins,email'.$this->admin->id;
        }

        return $rules;

    }
}
