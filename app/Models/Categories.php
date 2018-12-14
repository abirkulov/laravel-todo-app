<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts;

class Categories extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
}
