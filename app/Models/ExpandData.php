<?php
namespace App\Models;

/**
 * App\Models\ExpandData
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpandData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpandData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpandData query()
 * @mixin \Eloquent
 */
class ExpandData extends BaseModel
{

    public static $_table;

    protected $table;

//    protected $id;

    public $timestamps = false;

    protected $guarded = [
//        'id'
    ];

    public function __construct($table = null)
    {
        parent::__construct();
        if (! isset($this->table)) {
            if (isset(self::$_table)) {
                $this->table = 'expand_data_' . self::$_table;
            } elseif (is_string($table)) {
                self::$_table = $table;
                $this->table = 'expand_data_' . self::$_table;
            }
        }
    }

    public function setTableName($tableName)
    {
        self::$_table = $tableName;
        $this->table = 'expand_data_' . self::$_table;
        return $this;
    }

    public function checkData(array $data, int $expandId)
    {
        $expandFieldList = ExpandField::where('expand_id', $expandId)->orderBy('sequence')->get();
        $newData = [];
        foreach ($expandFieldList as $expandField) {
            $value = $data[$expandField->field] ?? null;
            switch ($expandField->type) {
                case 1:
                    switch ($expandField->property) {
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
                    $urlArr = (isset($data[$expandField->field . '_url'])
                        && is_array($data[$expandField->field . '_url'])) ? $data[$expandField->field . '_url'] : [];
                    $values = [];
                    foreach ($urlArr as $k => $v) {
                        $values[$k] = [
                            'url' => $v,
                            'thumbnail_url' => $data[$expandField->field . '_thumbnail_url'][$k] ?? '',
                            'title' => $data[$expandField->field . '_title'][$k] ?? '',
                            'order' => $data[$expandField->field . '_order'][$k] ?? '0'
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
                    $configArr = json_decode($expandField->config, true);
                    $values = array_keys($configArr);
                    if (! in_array($value, $values)) {
                        return $this->appendMessage($expandField->name . '选择错误！');
                    }
                    break;
                case 9:
                    if (is_null($value)) {
                        break;
                    }
                    $configArr = json_decode($expandField->config, true);
                    $values = array_keys($configArr);
                    foreach ($value as $v) {
                        if (! in_array($v, $values)) {
                            return $this->appendMessage($expandField->name . '选择错误！');
                        }
                    }
                    $value = implode(',', $value);
                    break;
            }
            if ($expandField->is_must && is_null($value)) {
                return $this->appendMessage($expandField->name . '不能为空！');
            }
            if ($expandField->regex && ! preg_match($expandField->regex, $value)) {
                return $this->appendMessage($expandField->name . '错误！');
            }
            if ($expandField->is_unique) {
                $query = self::query()->where($expandField->field, $value);
                if (isset($data['id'])) {
                    $query = $query->where('id', '<>', $data['id']);
                }
                if ($query->count()) {
                    return $this->appendMessage($expandField->name . '已存在！');
                }
            }
            $newData[$expandField->field] = $value;
        }
        return $newData;
    }

    public function add(array $data, int $expandId)
    {
        $newData = $this->checkData($data, $expandId);
        if ($newData === false) {
            return false;
        }
        $newData['content_id'] = $data['content_id'];
        $res = self::insert($newData);
        if (! $res) {
            return $this->appendMessage('添加失败');
        }
        return $res;
    }

    public function edit(array $data, int $expandId)
    {
        $contentId = $data['content_id'] ?? 0;
        $info = self::where('content_id', $contentId)->first();
        if (! $info) {
            return $this->appendMessage('记录不存在', 404);
        }
        $data = $this->checkData($data, $expandId);
        if ($data === false) {
            return false;
        }
        $res = $info->fill($data)->save();
        if (! $res) {
            return $this->appendMessage('修改失败');
        }
        return $res;
    }
}
