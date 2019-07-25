<?php
namespace App\Models;

/**
 * App\Models\CategoryJump
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id category表id
 * @property string $url 跳转地址
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryJump whereUrl($value)
 */
class CategoryJump extends BaseModel
{

    protected $table = 'category_jump';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'url'
    ];
}
