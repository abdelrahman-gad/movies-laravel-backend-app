<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'email' => 'required|string|unique:users,email',
			'birth_date'=>'required|date',
			'password' => 'required|string|confirmed'
        ];
    }
    public function passedValidation(): void
	{
		$this->merge(['password'=> bcrypt($this['password'])]);
	}
}
