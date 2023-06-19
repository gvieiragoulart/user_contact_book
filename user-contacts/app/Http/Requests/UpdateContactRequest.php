<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'name' => [
                'nullable',
                'min:3',
                'max:100',
            ],
            'secondName' => [
                'nullable',
                'min:3',
                'max:100',
            ],
            'email' => [
                'nullable',
                'min:3',
                'max:100',
                'email',
                'unique:contacts,email',
            ],
            'number' => [
                'nullable',
                'unique:contacts,number',
                'regex:/^\(\d{2}\)\d{4,5}\d{4}$/',
            ]
        ];
    }
}
