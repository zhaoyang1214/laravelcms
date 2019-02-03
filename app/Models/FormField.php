<?php
namespace App\Models;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class FormField extends BaseModel
{

    protected $table = 'form_field';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'form_id',
        'name',
        'field',
        'type',
        'property',
        'len',
        'decimal',
        'default',
        'sequence',
        'tip',
        'config',
        'is_must',
        'is_unique',
        'is_index',
        'regex',
        'admin_display',
        'admin_display_len'
    ];

    public function getTypeProperty(int $type = null, $property = null)
    {
        $data = [
            1 => [
                'text' => '单行文本',
                'property' => [
                    1 => 'varchar',
                    2 => 'int',
                    4 => 'datetime',
                    5 => 'decimal'
                ]
            ],
            2 => [
                'text' => '多行文本',
                'property' => [
                    1 => 'varchar',
                    3 => 'text'
                ]
            ],
            3 => [
                'text' => '编辑器',
                'property' => [
                    3 => 'text',
                    1 => 'varchar'
                ]
            ],
            4 => [
                'text' => '文件上传',
                'property' => [
                    1 => 'varchar'
                ]
            ],
            5 => [
                'text' => '单图片上传',
                'property' => [
                    1 => 'varchar'
                ]
            ],
            6 => [
                'text' => '组图上传',
                'property' => [
                    3 => 'text',
                    1 => 'varchar'
                ]
            ],
            7 => [
                'text' => '下拉菜单',
                'property' => [
                    1 => 'varchar',
                    2 => 'int'
                ]
            ],
            8 => [
                'text' => '单选',
                'property' => [
                    1 => 'varchar',
                    2 => 'int'
                ]
            ],
            9 => [
                'text' => '多选',
                'property' => [
                    1 => 'varchar'
                ]
            ]
        ];
        if (is_null($type)) {
            return $data;
        }
        if (is_null($property)) {
            return $data[$type];
        }
        if ($property === false) {
            return $data[$type]['text'];
        }
        if ($property === true) {
            return $data[$type]['property'];
        }
        return $data[$type]['property'][$property];
    }

    public function add(array $data)
    {
        try {
            $form = Form::find($data['form_id']);
            Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data) {
                switch ($data['property']) {
                    case 1:
                        $fieldObj = $table->string($data['field'], $data['len']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 2:
                        $fieldObj = $table->integer($data['field']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 3:
                        $table->text($data['field']);
                        break;
                    case 4:
                        $fieldObj = $table->dateTime($data['field']);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                    case 5:
                        $len = $data['len'] > 65 ? 65 : $data['len'];
                        $decimal = $data['decimal'] > 30 ? 30 : $data['decimal'];
                        $fieldObj = $table->decimal($data['field'], $len + $decimal, $decimal);
                        if (! $data['is_must']) {
                            $fieldObj->nullable();
                        }
                        break;
                }
                if ($data['is_unique'] == 1) {
                    $table->unique($data['field'], $data['field']);
                } else if ($data['is_index'] == 1) {
                    $table->index($data['field'], $data['field']);
                }
            });
            $res = self::create($data);
            if (! $res) {
                Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data) {
                    if ($data['is_unique'] == 1) {
                        $table->dropUnique($data['field']);
                    } else if ($data['is_index'] == 1) {
                        $table->dropIndex($data['field']);
                    }
                    $table->dropColumn($data['field']);
                });
            }
            return $res;
        } catch (\Exception $e) {
            return $this->appendMessage($e->getMessage());
        }
    }

    public function getOne(int $id)
    {
        $info = self::find($id);
        if (! $info) {
            return $this->appendMessage('该字段不存在');
        }
        $formInfo = (new Form())->getOne($info->form_id);
        if (! $formInfo) {
            return $this->appendMessage('该字段不存在');
        }
        return $info;
    }

    public function edit(int $id, array $data)
    {
        $info = self::find($id);
        $form = Form::find($info->form_id);
        Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($data, $info) {
            if ($info->is_unique == 1 && $data['is_unique'] == 0) {
                $table->dropUnique($info->field);
            } else if ($info->is_unique == 0) {
                if ($data['is_unique'] == 1) {
                    if ($info->is_index == 1) {
                        $table->dropIndex($info->field);
                    }
                    $table->unique($info->field, $info->field);
                } else if ($info->is_index == 1 && $data['is_index'] == 0) {
                    $table->dropIndex($info->field);
                } else if ($info->is_index == 0 && $data['is_index'] == 1) {
                    $table->index($info->field, $info->field);
                }
            }
        });
        return $info->fill($data)->save();
    }

    public function deleteById(int $id)
    {
        $info = $this->getOne($id);
        if (! $info) {
            return $this->appendMessage('该字段不存在');
        }
        $form = Form::find($info->form_id);
        Schema::table('form_data_' . $form->table, function (Blueprint $table) use ($info) {
            $table->dropColumn($info->field);
        });
        return $info->delete();
    }
}
