<?php

namespace App\Models;


class Role extends \Spatie\Permission\Models\Role
{
    public function isNotSelf($id)
    {
        return $this->id != $id;
    }
}
