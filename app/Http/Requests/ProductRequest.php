<?php

namespace App\Http\Requests;

use App\Libraries\ResponseBase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if ($this->routeIs('products.store')) {
            return [
                'name' => 'required|string|unique:products|max:255',
            ];
        } elseif ($this->routeIs('products.update')) {
            return [
                'name' => 'nullable|string|max:255|unique:products,name,' . $this->id,
            ];
        }

        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException(
            ResponseBase::error($validator->errors(), 422)
        );
    }
}
