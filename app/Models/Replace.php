<?php
namespace App\Models;

/**
 * App\Models\Replace
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $key 关键字
 * @property string $content 要替换的内容
 * @property int $num 替换次数，0：不限制
 * @property int $status 状态，0：禁用，1：启用
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Replace whereUpdateTime($value)
 */
class Replace extends BaseModel
{

    protected $table = 'replace';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'id',
        'key',
        'content',
        'num',
        'status'
    ];
}
