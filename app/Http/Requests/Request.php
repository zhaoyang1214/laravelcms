<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Request extends FormRequest
{

    /**
     * 格式化错误信息
     *
     * @param Illuminate\Contracts\Validation\Validator $validator            
     * @return : array
     */
    protected function formatErrors(Validator $validator)
    {
        return [
            'status' => - 10000,
            'message' => $validator->errors()->first()
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($this->formatErrors($validator)));
    }
}
