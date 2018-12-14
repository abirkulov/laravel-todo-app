<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Posts;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Posts $post)
    {
        return $post && $user->id == $post->user_id;
    }

    public function delete(User $user, Posts $post)
    {
        return $post && $user->id == $post->user_id;
    }
}
