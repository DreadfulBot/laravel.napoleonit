<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $fillable = [
        'id', 'category', 'created_at', 'updated_at'
    ];

    public function article() {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }
}
