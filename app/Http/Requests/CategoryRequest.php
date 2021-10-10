<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if($this->getMethod() == 'POST')
        {
            return [
                'name_en' => 'required|string|max:255|unique:categories,name_en',
                'name_ar' => 'required|string|max:255|unique:categories,name_ar',
                'img' => 'required|image|mimes:png,jpg|max:512',
            ];
        }

        return [
            'name_en' => 'required|string|max:255|unique:categories,name_en,' . $this->category->id,
            'name_ar' => 'required|string|max:255|unique:categories,name_ar,' . $this->category->id,
            'img' => 'nullable|image|mimes:png,jpg|max:512',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => __('category.Please Enter Category Name In English'),
            'name_ar.required' => __('category.Please Enter Category Name In Arabic'),
            'name_en.unique' => __('category.Name In English has aleady been taken'),
            'name_ar.unique' => __('category.Name In Arabic has aleady been taken'),
            'img.required' => __('category.Please Choose an Image to upload'),
            'img.max' => __('category.Max'),
            'img.mimes' => __('category.mimes'),
            'img.image' => __('category.mimes'),
        ];
    }
}
