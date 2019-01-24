<?php
namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;
use App\Models\Admin;

class EditInfoRequest extends Request
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
            $rules['id'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $admin = new Admin();
                    $info = $admin->getOneOrSelf(intval($value));
                    if (! $info) {
                        return $fail('该管理员不存在');
                    }
                }
            ];
            $rules['nickname'] = 'required|between:2,20';
            if ($this->post('password') !== '') {
                $rules['password'] = 'required|between:6,20|confirmed';
                $rules['password_confirmation'] = 'required';
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'nickname.required' => '请输入昵称',
            'nickname.between' => '昵称长度位2-20位',
            'password.required' => '请输入密码',
            'password.between' => '密码长度位6-20位',
            'password.confirmed' => '两次密码不一致',
            'password_confirmation.required' => '请输入确认密码'
        ];
    }
}
