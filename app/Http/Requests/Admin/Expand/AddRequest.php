<?php
namespace App\Http\Requests\Admin\Expand;

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
            $rules = [
                'name' => 'required|between:2,50|unique:expand',
                'table' => [
                    'required',
                    'regex:/^[a-zA-Z]\w{1,20}$/',
                    'unique:expand'
                ],
                'sequence' => 'required|integer'
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请输入表单名称',
            'name.between' => '表单名称长度必须在2-50个字符之间',
            'name.unique' => '表单名称已存在',
            'table.required' => '请输入表名',
            'table.regex' => '表名为2-20位以字母开头的字母、数字、下划线',
            'table.unique' => '表名已存在',
            'sequence.required' => '请输入表单顺序',
            'sequence.integer' => '表单顺序必须为整数'
        ];
    }
}