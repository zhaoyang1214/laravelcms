<?php
namespace App\Models;

/**
 * App\Models\Tags
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $tags_group_id tags_group表id
 * @property string $name 标签名
 * @property int $click 点击次数
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereClick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereTagsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tags whereUpdateTime($value)
 */
class Tags extends BaseModel
{

    protected $table = 'tags';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'tags_group_id',
        'name',
        'click'
    ];
}
