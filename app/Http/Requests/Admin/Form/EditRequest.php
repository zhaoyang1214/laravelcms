<?php
namespace App\Http\Requests\Admin\Form;

use App\Models\Form;

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
        array_prepend($rules, [
            'required',
            function ($attribute, $value, $fail) {
                $form = new Form();
                $info = $form->getOne(intval($value));
                if (! $info) {
                    return $fail('该表单不存在');
                }
            }
        ], 'id');
        $rules['name'] = 'required|between:2,50|unique:form,name,' . $this->post('id', 0);
        $rules['table'] = function ($attribute, $value, $fail) {
            return $fail('不允许修改表名');
        };
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入表单名称',
            'name.between' => '表单名称长度必须在2-50个字符之间',
            'name.unique' => '表单名称已存在',
            'table.required' => '请输入表名',
            'table.regex' => '表名为2-20位字符、数字、_',
            'table.unique' => '表名已存在',
            'sequence.required' => '请输入表单顺序',
            'sequence.integer' => '表单顺序必须为整数',
            'sort.required' => '请输入内容排序',
            'sort.regex' => '内容排序必须为0-20位数字、字母、下划线、空格、逗号'
        ];
    }
}