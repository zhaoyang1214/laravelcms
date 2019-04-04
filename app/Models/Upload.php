<?php
namespace App\Models;

class Upload extends BaseModel
{

    protected $table = 'upload';

    public $timestamps = false;

    protected $fillable = [
        'file',
        'folder',
        'title',
        'ext',
        'size',
        'type',
        'time',
        'module'
    ];

    public function getModule(int $module = null)
    {
        $moduleArr = [
            - 1 => '未绑定模块',
            1 => '栏目模块',
            2 => '内容模块',
            3 => '扩展模块',
            4 => '表单模块'
        ];
        if (is_null($module)) {
            return $moduleArr;
        }
        return $moduleArr[$module] ?? '未知';
    }
}
