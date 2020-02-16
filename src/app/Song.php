<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['title', 'image', 'link'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_song');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
