<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
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
            'name'=>['required','max:255'],
            'category_id' => ['required',Rule::notIn([0]),'integer'],
            'description'=>['required','max:1000'],
            'condition_id'=>['required',Rule::notIn([0]),'integer'],
            'price'=>['required','integer','min:99','max:150000000'],
            'stock'=>['required','integer'],
            'image'=>['required']
        ];
    }
}
