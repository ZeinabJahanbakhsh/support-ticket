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
        /*dd($this->route('label')->id,
            $this);*/

        //dd(Rule::unique(Guidance::class, 'employment_no')->ignore($guidance));

        return [
            //'name' => ['required', 'string', 'max:200', 'min:3', Rule::unique('labels', 'name')->ignore($this->id)]
            //'name' => ['required', 'string', 'max:200', 'min:3', Rule::unique('labels', 'name')->ignore($this->route($this->route('label'))->id)]
            //'name' => ['required', 'string', 'max:200', 'min:3', Rule::unique('labels', 'name')->ignore($this->label->id)]
            'name' => ['required', 'string', 'max:200', 'min:3'/*, Rule::unique(Label::class, 'name')*//*->ignore($this->route('label'))*/]
            //'name' => ['required', 'string', 'max:200', 'min:3', 'unique:labels,name,' . $this->label->id ],
            //'unique:users,name,' . $this->user
            //'email' => ['nullable', 'string', 'email', 'max:100', 'unique:users,email,' . $this->user . ',user_id'],
            //'email' => 'required|email|unique:users,email,'.$this->user->id,
            //'email' => 'required|email|unique:users,email,'.$this->user()->id,


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
