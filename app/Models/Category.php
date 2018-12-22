<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Category extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function isNotSelf($id)
    {
        return $this->id != $id;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
