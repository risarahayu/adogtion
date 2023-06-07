<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class StoreVetRequest extends FormRequest
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
            // Use this for real validation
            // 'area_id' => ['required', 'integer', Rule::exists('areas', 'id')],
            // 'name' => 'required|string|max:255',
            // 'telephone' => 'nullable|required|string|max:20',
            // 'whatsapp' => 'nullable|string|max:20',
            // 'day_open' => 'required|integer',
            // 'day_close' => 'required|integer',
            // 'hour_open' => 'required|date_format:H:i',
            // 'hour_close' => 'required|date_format:H:i|after:hour_open',
            // 'fullday' => 'boolean',

            // For testing purposes
            'area' => 'required',
            'name' => 'required',
            'telephone' => 'nullable|required',
            'whatsapp' => 'nullable|required',
            'day_open' => 'required',
            'day_close' => 'required',
            'hour_open' => 'required',
            'hour_close' => 'required',
            'fullday' => 'boolean',
        ];
    }
}
