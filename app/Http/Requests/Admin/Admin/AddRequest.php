<?php
namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\Request;
use App\Models\AdminGroup;

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
        return $this->isMethod('post') ? [
            'username' => [
                'required',
                'regex:/^[\w@\.]{5,20}$/',
                'unique:admin'
            ],
            'nickname' => 'required|between:2,20',
            'password' => 'required|between:6,20|confirmed',
            'password_confirmation' => 'required',
            'status' => 'required|in:0,1',
            'admin_group_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $list = AdminGroup::getLowerList()->toArray();
                    $ids = array_column($list, 'id');
                    if (! in_array($value, $ids)) {
                        return $fail('管理组错误');
                    }
                }
            ]
        ] : [];
    }

    public function messages()
    {
        return [
            'username.required' => '请输入管理员账号',
            'username.regex' => '管理员账号必须在5-20位数字、字母、下划线、@或.',
            'username.unique' => '管理员账号已存在',
            'nickname.required' => '请输入昵称',
            'nickname.between' => '昵称长度位2-20位',
            'password.required' => '请输入密码',
            'password.between' => '密码长度位6-20位',
            'password.confirmed' => '两次密码不一致',
            'password_confirmation.required' => '请输入确认密码',
            'admin_group_id.required' => '请选择管理组'
        ];
    }
}
