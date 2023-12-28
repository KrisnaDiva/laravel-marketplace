<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:255'],
            'full_name' => ['required', 'max:255'],
            'phone_number' => ['required', 'min:12', 'max:13'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'district' => ['required', 'max:50'],
            'zip' => ['required', 'max:5'],
            'street' => ['required', 'max:255'],
            'others' => ['max:255'],
        ];
    }
}
