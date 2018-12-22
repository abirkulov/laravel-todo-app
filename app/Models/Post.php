<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Image;

class Post extends Model
{
    protected $fillable = [
        'title', 'text', 'image', 'user_id',
        'category_id'
    ];

    public function isNotSelf($id)
    {
        return $this->id != $id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
