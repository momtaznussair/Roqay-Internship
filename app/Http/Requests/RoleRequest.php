<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
                'name' => 'required|max:255|unique:roles,name',
                'permissions' => 'required|exists:permissions,id',
            ];
        }

        return [
            'name' => 'required|max:255|unique:roles,name,'. $this->role->id,
            'permissions' => 'required|exists:permissions,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('roles.Plese Enter Role Name'),
            'name.unique' => __('roles.Name Already Taken'),
            'name.max' => __('roles.Name Must be under 256 characters'),
            'permissions.required' => __('roles.Select At least one Permission'),
            'permissions.exists' => __('roles.Sorry Error In permissions'),
        ];
    }
}
