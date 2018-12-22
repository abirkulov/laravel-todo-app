<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public function isNotSelf($id)
    {
        return $this->id != $id;
    }
}
