<?php
namespace App\Http\Requests\Admin\Admingroup;

use App\Models\AdminGroup;

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
        $rules = parent::rules();
        $rules = array_prepend($rules, [
            'required',
            function ($attribute, $value, $fail) {
                $adminGroup = new AdminGroup();
                $info = $adminGroup->getOne(intval($value));
                if (! $info) {
                    return $fail($adminGroup->getMessages()[0]['message']);
                }
            }
        ], 'id');
        $rules['name'] = 'required|between:2,50|unique:admin_group,name,' . $this->post('id', 0);
        return $rules;
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages['id.required'] = '非法请求';
        return $messages;
    }
}
