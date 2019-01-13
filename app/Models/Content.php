<?php
namespace App\Models;

class Content extends BaseModel
{

    protected $table = 'content';

    const CREATED_AT = 'input_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'category_id',
        'title',
        'urltitle',
        'subtitle',
        'font_color',
        'font_bold',
        'keywords',
        'description',
        'image',
        'jump_url',
        'sequence',
        'tpl',
        'status',
        'copyfrom',
        'views',
        'position',
        'taglink'
    ];
}
