<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreTicketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:300', 'min:3'],
            'description'  => ['required', 'string', 'max:1500', 'min:3'],
            'attachment'   => ['nullable', 'string' /*'base64_image_size:500'*/],
            'priority_id'  => ['nullable', 'integer', 'exists:priorities,id'],
            'status_id'    => ['required', 'integer', 'exists:statuses,id'],
            'category_ids' => ['nullable', 'array', 'exists:categories,id'],
            'label_ids'    => ['nullable', 'array', 'exists:labels,id']
        ];
    }
}
