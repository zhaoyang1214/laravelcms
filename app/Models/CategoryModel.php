<?php
namespace App\Models;

/**
 * App\Models\CategoryModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 模型名称
 * @property string $category 栏目控制器名
 * @property string $content 栏目控制器名
 * @property int $status 状态，0：禁用，1：开启
 * @property string $befrom 来源
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereBefrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryModel whereUpdateTime($value)
 */
class CategoryModel extends BaseModel
{

    protected $table = 'category_model';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'name',
        'category',
        'content',
        'status',
        'befrom',
        'create_time',
        'update_time'
    ];

    public function getAllowCategoryList()
    {
        $list = self::where('status', 1)->get()->toArray();
        $admin = new Admin();
        foreach ($list as $k => $v) {
            if (! $admin->checkPower($v['category'], 'add')) {
                unset($list[$k]);
            }
        }
        return $list;
    }
}
