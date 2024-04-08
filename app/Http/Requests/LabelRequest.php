<?php

namespace App\Http\Requests;

use App\Models\Label;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;


class LabelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => ['required', 'string', 'max:200', 'min:3']
        ];
    }

    protected function failedValidation(Validator $validator): JsonResponse
    {
        $errors = $validator->errors();
        return response()->json([
            'message' => $errors->messages(),
        ], 422);

        //throw new HttpResponseException($response);
    }


}
