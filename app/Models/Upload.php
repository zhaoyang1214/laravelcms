<?php
namespace App\Models;

/**
 * App\Models\Upload
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $file 文件
 * @property string $folder 文件路径
 * @property string $title 文件名
 * @property string $ext 文件扩展名
 * @property int $size 文件大小
 * @property string $type 文件类型
 * @property string $time 上传时间
 * @property int $module 所属模块，-1:未绑定模块；1：栏目模块，2：内容模块，3：扩展模块，4：表单模块
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Upload whereType($value)
 */
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
