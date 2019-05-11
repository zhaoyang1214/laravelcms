<?php
namespace App\Models;

class CategoryJump extends BaseModel
{

    protected $table = 'category_jump';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'url'
    ];
}
