<?php
namespace App\Http\Requests\Admin\Formfield;

use App\Http\Requests\Request;
use App\Models\Form;
use App\Models\FormField;

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
            $rules = [
                'form_id' => [
                    'required',
                    'integer',
                    function ($attribute, $value, $fail) {
                        $form = new Form();
                        $info = $form->getOne(intval($value));
                        if (! $info) {
                            return $fail('该表单不存在');
                        }
                    }
                ],
                'name' => [
                    'required',
                    'between:2,50',
                    function ($attrbute, $value, $fail) {
                        $formField = FormField::where('form_id', $this->post('form_id'))->Where('name', $value);
                        $id = $this->post('id', 0);
                        if (! empty($id)) {
                            $formField = $formField->andWhere('id', '<>', $id);
                        }
                        $count = $formField->count();
                        if ($count) {
                            return $fail('该字段描述已存在');
                        }
                    }
                ],
                'field' => [
                    'required',
                    'regex:/^[a-zA-Z]\w{1,20}$/',
                    function ($attrbute, $value, $fail) {
                        $count = FormField::where('form_id', $this->post('form_id'))->Where('field', $value)->count();
                        if ($count) {
                            return $fail('该字段名称已存在');
                        }
                    }
                ],
                'len' => 'required|integer|digits_between:0,65535',
                'decimal' => 'required|integer|digits_between:0,30',
                'sequence' => 'required|integer',
                'config' => function ($attrbute, $value, $fail) {
                    if (! empty($value) && is_null(json_decode($value, true))) {
                        return $fail('配置错误');
                    }
                },
                'regex' => 'regex:/^\/.*\/$/',
                'admin_display_len' => 'required|integer|digits_between:0,65535'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入字段描述',
            'name.between' => '字段描述长度为2 - 50位',
            'field.required' => '请输入字段名称',
            'field.regex' => '字段名称为2-20位以字母开头的字母、数字、下划线',
            'len.required' => '请输入字段长度',
            'len.integer' => '字段长度只能为正整数和0',
            'len.digits_between' => '字段长度只能为正整数和0',
            'decimal.required' => '请输入小数位数',
            'decimal.integer' => '小数位数只能为正整数和0',
            'decimal.digits_between' => '小数位数只能为正整数和0',
            'sequence.required' => '请输入字段顺序',
            'sequence.integer' => '字段顺序必须为整数',
            'regex.regex' => '正则验证规则错误',
            'admin_display_len.required' => '请输入后台列表显示长度',
            'admin_display_len.integer' => '后台列表显示长度只能为正整数和0',
            'admin_display_len.digits_between' => '后台列表显示长度只能为正整数和0'
        ];
    }
}