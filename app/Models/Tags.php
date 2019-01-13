<?php
namespace App\Models;

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
