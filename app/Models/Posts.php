<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Categories;
use App\Models\Images;

class Posts extends Model
{
    protected $fillable = [
        'title', 'text', 'image', 'user_id',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function image()
    {
        return $this->morphOne(Images::class, 'imageable');
    }
}
