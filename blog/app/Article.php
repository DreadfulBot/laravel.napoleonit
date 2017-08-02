<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $fillable = [
        'id', 'category_id', 'user_id', 'image', 'title', 'description', 'content'
    ];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
