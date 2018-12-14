<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'mime', 'imageable_id', 'imageable_type'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
