<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class TickerRequest extends FormRequest
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
            'title'       => ['required', 'string', 'max:300', 'min:3'],
            'description' => ['required', 'string', 'max:1500', 'min:3'],
            'attachment'  => [File::types(['png', 'jpg', 'docx', 'doc'])],
            'priority_id' => ['nullable', 'integer', 'exists:priorities,id'],
            'status_id'   => ['required', 'integer', 'exists:statuses,id'],
            'user_id'     => ['nullable', 'integer', 'exists:users,id']
        ];
    }
}
