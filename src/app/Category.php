<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'image'];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'category_song');
    }
}
