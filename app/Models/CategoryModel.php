<?php
namespace App\Models;

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
}
