<?php
namespace App\Models;

/**
 * App\Models\CategoryPage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id category表id
 * @property string $content 内容
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CategoryPage whereId($value)
 */
class CategoryPage extends BaseModel
{

    protected $table = 'category_page';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'content'
    ];
}
