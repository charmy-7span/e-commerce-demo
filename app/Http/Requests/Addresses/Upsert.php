<?php

namespace App\Http\Requests\Addresses;

use Illuminate\Foundation\Http\FormRequest;

class Upsert extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
           'country_id' => 'required|numeric|exists:countries,id',
           'state_id' => 'required|numeric|exists:states,id',
           'city_id' => 'required|exists:cities,id',
           'pin_code' => 'required|numeric',
           'address_line1' => 'required',
           'address_line2' => 'required'
        ];

        return $rules;
    }
}
