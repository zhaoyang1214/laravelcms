<?php
namespace App\Models;

class TagsGroup extends BaseModel
{

    protected $table = 'tags_group';

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $fillable = [
        'name'
    ];
}
