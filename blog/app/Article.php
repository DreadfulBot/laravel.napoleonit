<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $fillable = [
        'id', 'category_id', 'image', 'title', 'description', 'content'
    ];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
