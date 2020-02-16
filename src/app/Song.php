<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['title', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_song');
    }
}
