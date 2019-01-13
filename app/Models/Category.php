<?php
namespace App\Models;

class Category extends BaseModel
{

    protected $table = 'category';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'pid',
        'category_model_id',
        'sequence',
        'is_show',
        'type',
        'name',
        'urlname',
        'subname',
        'image',
        'category_tpl',
        'content_tpl',
        'page',
        'keywords',
        'description',
        'seo_content',
        'content_order',
        'expand_id'
    ];
}
