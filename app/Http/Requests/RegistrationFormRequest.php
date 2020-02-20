<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormRequest extends FormRequest
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
            'name' => 'required|string|min:',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ];
    }
}

/**
 *
 * EMAIL
 * email max 255
 * asunto min 6 max 80
 * mensaje min 10 max 516
 *
 * LISTA
 * titulo min 4 max 6
 * desc min 4 max 6
 * password min 4
 *
 * REg/log
 * email max 255
 * pass min 4
 * nombre min 4 max 60
 *
 *
 */
