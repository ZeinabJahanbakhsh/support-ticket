<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;


class UpdateTicketRequest extends FormRequest
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
        $rules = [
            'title'       => ['required', 'string', 'max:300', 'min:3'],
            'description' => ['required', 'string', 'max:1500', 'min:3'],
            'attachment'  => [File::types(['png', 'jpg', 'docx', 'doc'])],
            'priority_id' => ['nullable', 'integer', 'exists:priorities,id'],
            'status_id'   => ['required', 'integer', 'exists:statuses,id'],
        ];

        if (\Auth::user()->roles()->adminRole()->get()->isNotEmpty()){
            $rules['assigned_to'] = ['nullable', 'integer', 'exists:users,id'] ;
        }


        return $rules;
    }
}
