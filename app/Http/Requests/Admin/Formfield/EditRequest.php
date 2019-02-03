<?php
namespace App\Http\Requests\Admin\Formfield;

use App\Models\FormField;

class EditRequest extends AddRequest
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
        return array_prepend(parent::rules(), [
            'required',
            function ($attribute, $value, $fail) {
                $formField = new FormField();
                $info = $formField->getOne(intval($value));
                if (! $info) {
                    return $fail('该字段不存在');
                }
            }
        ], 'id');
    }

    public function messages()
    {
        return parent::messages();
    }
}