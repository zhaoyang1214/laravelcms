<?php
namespace App\Models;

class ContentData extends BaseModel
{

    protected $table = 'content_data';

    public $timestamps = false;

    protected $fillable = [
        'content_id',
        'content'
    ];
}
