<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStrayDogRequest extends FormRequest
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
        return [
            'user_id' => 'required',
            'area_id' => 'required',
            'dog_type' => 'required|string',
            'color' => 'required|string',
            'temperament' => 'required|string',
            'gender' => 'required|string',
            'size' => 'required|string',
            'description' => 'required|string',
            'map_link' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
