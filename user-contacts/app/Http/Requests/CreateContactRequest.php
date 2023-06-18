<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
                'required',
                'min:3',
                'max:100',
            ],
            'second_name' => [
                'nullable',
                'min:3',
                'max:100',
            ],
            'email' => [
                'required',
                'min:3',
                'max:100',
                'email',
                'unique:contacts,email',
            ],
            'number' => [
                'required',
                'unique:contacts,number',
                'regex:/^\(\d{2}\)\d{4,5}\d{4}$/',
            ],
            'image' => [
                'nullable',
                'image'
            ],
        ];
    }

    public function messages()
    {
        return [
            'number.regex' => 'O campo número de telefone deve estar no formato (99) 999999999 ou (99) 99999999.',
        ];
    }
}
