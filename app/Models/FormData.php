<?php
namespace App\Models;

class FormData extends BaseModel
{

    public static $_table;

    protected $table;

    public $timestamps = false;

    protected $guarded = [
        'id'
    ];

    public function __construct($table = null)
    {
        if (! isset($this->table)) {
            if (isset(self::$_table)) {
                $this->table = 'form_data_' . self::$_table;
            } else if (is_string($table)) {
                self::$_table = $table;
                $this->table = 'form_data_' . self::$_table;
            }
        }
    }

    public function checkData(array $data, int $formId)
    {
        $formFieldList = FormField::where('form_id', $formId)->orderBy('sequence')->get();
        $newData = [];
        foreach ($formFieldList as $formField) {
            $value = $data[$formField->field] ?? null;
            switch ($formField->type) {
                case 1:
                    switch ($formField->property) {
                        case 2:
                            $value = intval($value);
                            break;
                        case 4:
                            $value = date('Y-m-d H:i:s', strtotime($value));
                            break;
                    }
                    break;
                case 3:
                    $value = htmlspecialchars($value);
                    break;
                case 6:
                    $urlArr = (isset($data[$formField->field . '_url']) && is_array($data[$formField->field . '_url'])) ? $data[$formField->field . '_url'] : [];
                    $values = [];
                    foreach ($urlArr as $k => $v) {
                        $values[$k] = [
                            'url' => $v,
                            'thumbnail_url' => $data[$formField->field . '_thumbnail_url'][$k] ?? '',
                            'title' => $data[$formField->field . '_title'][$k] ?? '',
                            'order' => $data[$formField->field . '_order'][$k] ?? '0'
                        ];
                    }
                    array_multisort(array_column($values, 'order'), SORT_ASC, $values);
                    $value = empty($values) ? '' : json_encode($values);
                    break;
                case 7:
                case 8:
                    if (is_null($value)) {
                        break;
                    }
                    $configArr = json_decode($formField->config, true);
                    $values = array_keys($configArr);
                    if (! in_array($value, $values)) {
                        return $this->appendMessage($formField->name . '选择错误！');
                    }
                    break;
                case 9:
                    if (is_null($value)) {
                        break;
                    }
                    $configArr = json_decode($formField->config, true);
                    $values = array_keys($configArr);
                    foreach ($value as $v) {
                        if (! in_array($v, $values)) {
                            return $this->appendMessage($formField->name . '选择错误！');
                        }
                    }
                    $value = implode(',', $value);
                    break;
            }
            if ($formField->is_must && is_null($value)) {
                return $this->appendMessage($formField->name . '不能为空！');
            }
            if ($formField->regex && ! preg_match($formField->regex, $value)) {
                return $this->appendMessage($formField->name . '错误！');
            }
            if ($formField->is_unique) {
                $query = self::query()->where($formField->field, $value);
                if (isset($data['id'])) {
                    $query = $query->where('id', '<>', $data['id']);
                }
                if ($query->count()) {
                    return $this->appendMessage($formField->name . '已存在！');
                }
            }
            $newData[$formField->field] = $value;
        }
        return $newData;
    }

    public function add(array $data, int $formId)
    {
        $data = $this->checkData($data, $formId);
        if ($data === false) {
            return false;
        }
        $res = $this->fill($data)->save();
        if (! $res) {
            return $this->appendMessage('添加失败');
        }
        return $res;
    }
}
