<?php
namespace App\Http\Requests\Admin\Admingroup;

use App\Http\Requests\Request;
use App\Models\AdminAuth;
use App\Models\Category;
use App\Models\Form;

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
            'name' => 'required|between:2,50|unique:admin_group',
            'grade' => [
                'integer',
                function ($attribute, $value, $fail) {
                    $adminGroupInfo = session('adminGroupInfo');
                    if ($value <= $adminGroupInfo['grade']) {
                        return $fail('级别错误');
                    }
                }
            ],
            'keep' => [
                'integer',
                function ($attribute, $value, $fail) {
                    $adminGroupInfo = session('adminGroupInfo');
                    if (($value | $adminGroupInfo['keep']) != $adminGroupInfo['keep']) {
                        return $fail('无需校验的权限错误');
                    }
                }
            ],
            'admin_auth_ids' => function ($attribute, $value, $fail) {
                $keep = $this->post('keep');
                if (! (($keep & 4) || empty($value))) {
                    $arr = explode(',', $value);
                    $adminGroupInfo = session('adminGroupInfo');
                    if ($adminGroupInfo['keep'] & 4) {
                        $adminAuthList = (new AdminAuth())->getAllowList();
                        $adminAuthIdArr = array_column($adminAuthList, 'id');
                    } else {
                        $adminAuthIdArr = $adminGroupInfo['admin_auth_id_arr'];
                    }
                    if (! empty(array_diff($arr, $adminAuthIdArr))) {
                        return $fail('功能操作权限错误');
                    }
                }
            },
            'category_ids' => function ($attribute, $value, $fail) {
                $keep = $this->post('keep');
                if (! (($keep & 2) || empty($value))) {
                    $arr = explode(',', $value);
                    $adminGroupInfo = session('adminGroupInfo');
                    if ($adminGroupInfo['keep'] & 2) {
                        $categoryList = (new Category())->getAllowList();
                        $categoryIdArr = array_column($categoryList, 'id');
                    } else {
                        $categoryIdArr = $adminGroupInfo['category_id_arr'];
                    }
                    if (! empty(array_diff($arr, $categoryIdArr))) {
                        return $fail('栏目操作权限错误');
                    }
                }
            },
            'form_ids' => function ($attribute, $value, $fail) {
                $keep = $this->post('keep');
                if (! (($keep & 1) || empty($value))) {
                    $arr = explode(',', $value);
                    $adminGroupInfo = session('adminGroupInfo');
                    if ($adminGroupInfo['keep'] & 1) {
                        $formList = (new Form())->getAllowList();
                        $formIdArr = array_column($formList, 'id');
                    } else {
                        $formIdArr = $adminGroupInfo['form_id_arr'];
                    }
                    if (! empty(array_diff($arr, $formIdArr))) {
                        return $fail('多功能表单权限错误');
                    }
                }
            }
        ] : [];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入管理组名称',
            'name.between' => '管理组名称长度必须在2-50个字符之间',
            'name.unique' => '管理组名称已存在'
        ];
    }
}
