<?php
namespace App\Models;

class ContentTags extends BaseModel
{

    protected $table = 'content_tags';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'tags_id'
    ];
}
