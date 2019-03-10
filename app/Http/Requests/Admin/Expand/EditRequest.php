<?php
namespace App\Http\Requests\Admin\Expand;

use App\Models\Expand;

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
                $info = Expand::find(intval($value));
                if (! $info) {
                    return $fail('该表单不存在');
                }
            }
        ], 'id');
        $rules['name'] = 'required|between:2,50|unique:expand,name,' . $this->post('id', 0);
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
            'sequence.required' => '请输入表单顺序',
            'sequence.integer' => '表单顺序必须为整数'
        ];
    }
}