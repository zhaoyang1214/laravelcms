<?php
namespace App\Models;

class CategoryPage extends BaseModel
{

    protected $table = 'category_page';

    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'content'
    ];
}
