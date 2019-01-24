<?php
namespace App\Http\Requests\Admin\Admin;

use App\Models\Admin;

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
                $admin = new Admin();
                $info = $admin->getOne(intval($value));
                if (! $info) {
                    return $fail('该管理员不存在');
                }
            }
        ], 'id');
        $rules['username'] = [
            'required',
            'regex:/^[\w@\.]{5,20}$/',
            'unique:admin,username,' . $this->post('id', 0)
        ];
        $rules['username'] = 'required|between:5,20|unique:admin_group,name,' . $this->post('id', 0);
        if ($this->post('password') === '') {
            unset($rules['password']);
            unset($rules['password_confirmation']);
        }
        return $rules;
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages['id.required'] = '非法请求';
        return $messages;
    }
}
