<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecordRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'category_id' => [
                'sometimes',
                'integer',
                'exists:categories,id'
            ],
            'type' => [
                'sometimes',
                'string',
                'in:income,expense'
            ],
            'amount' => [
                'sometimes',
                'numeric',
                'between:0.01,100000.00'
            ],
            'note' => [
                'sometimes',
                'nullable',
                'string',
                'max:255'
            ],
            'record_date' => [
                'sometimes',
                'date'
            ]
        ];
    }
}
