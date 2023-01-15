<?php

namespace App\Http\Requests\Movies;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
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

	public function rules()
	{
		return [
			'title' => 'sometimes|string|between:6,255|unique:movies,title',
			'description' => 'sometimes|between:10,600',
			'rate' => 'sometimes|digits_between:0,5',
			'image' => 'sometimes|image|max:255',
			'category_id' => 'sometimes|integer|exists:categories,id'
		];
	}
}
