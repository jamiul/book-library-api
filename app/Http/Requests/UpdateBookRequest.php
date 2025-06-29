<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            "bookshelf_id" => "sometimes|required|exists:bookshelves,id",
            "title" => "sometimes|required|string|max:255",
            "author" => "sometimes|required|string|max:255",
            "published_year" => "sometimes|required|integer|digits:4|min:1000|max:" . date("Y"),
        ];
    }
}
