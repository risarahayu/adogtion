<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVetRequest extends FormRequest
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
        $rules = [
            // Use this for real validation
            'area' => 'required|string',
            'map_link' => 'required|string',
            'name' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'schedule.*.day_name' => 'required|string',
            'schedule.*.open_day' => 'nullable',
            'schedule.*.open_hour' => 'required_if:schedule.*.open_day,true',
            'schedule.*.close_hour' => 'required_if:schedule.*.open_day,true',
            'schedule.*.fullday' => 'nullable',
        ];
        
        return $rules;return [
            //
        ];
    }
}
