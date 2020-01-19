<?php


namespace App\Traits;


use App\Http\Controllers\Api\ApiController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait RequestValidationError
{
    protected function failedValidation(Validator $validator)
    {
        $errors = (new  ValidationException($validator))->errors();

        throw (new HttpResponseException(
            (new ApiController())->apiResponse($errors, "Validation Error!",JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        ));
    }}
