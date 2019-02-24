<?php
namespace App\Http\Requests\Admin\Formdata;

use App\Http\Requests\Request;

class AddRequest extends Request
{

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
        $rules = [];
        if ($this->isMethod('post')) {
            $rules = [];
        }
        return $rules;
    }

    public function messages()
    {
        return [];
    }
}