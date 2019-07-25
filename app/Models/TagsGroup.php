<?php
namespace App\Models;

/**
 * App\Models\TagsGroup
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 标签组名
 * @property \Illuminate\Support\Carbon $create_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 修改时间
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup whereCreateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TagsGroup whereUpdateTime($value)
 */
class TagsGroup extends BaseModel
{

    protected $table = 'tags_group';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'name'
    ];
}
