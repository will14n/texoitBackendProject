<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class  StoreUpdateMovieRequest extends FormRequest
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
            'year' => [
                'required',
                'min:4',
                'max:4'
            ],
            'title' => 'required',
            'studios' => 'required',
            'producers' => 'required',
            'winner' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'year' => [
                'required' => 'Year is required!',
                'min' => 'Your "year" is too short!',
                'max' => 'Your "year" is too long!'
            ],
            'title.required' => 'Movie title is required!',
            'studios.required' => 'Studio is required!',
            'producers.required' => 'Producer is required!',
        ];
    }
}
