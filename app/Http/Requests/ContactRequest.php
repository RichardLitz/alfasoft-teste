<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|min:5',
            'phone' => [
                'required',
                'string', 
                'size:9',
                'regex:/^[0-9]+$/',
                Rule::unique('contacts')->ignore($this->contact),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('contacts')->ignore($this->contact),
            ],
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve ter pelo menos 5 caracteres',
            'phone.required' => 'O telefone é obrigatório',
            'phone.size' => 'O telefone deve ter exatamente 9 dígitos',
            'phone.regex' => 'O telefone deve conter apenas números',
            'phone.unique' => 'Este telefone já está cadastrado',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Por favor, informe um e-mail válido',
            'email.unique' => 'Este e-mail já está cadastrado',
        ];
    }
}