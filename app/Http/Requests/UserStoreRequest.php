<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use App\Traits\RequestValidationError;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{
    use RequestValidationError;
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
            "first_name" => "required",
            "last_name"  => "required",
            "email"  => "required|unique:users",
            "password"   => "required"
        ];
    }


}
