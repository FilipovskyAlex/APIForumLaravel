<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PostPolicy
 * @package App\Policies
 */
class PostPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post) : bool
    {
        return $user->onwsPost($post);
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post) : bool
    {
        return $user->onwsPost($post);
    }

    public function like(User $user, Post $post) : bool
    {
        return !$user->onwsPost($post);
    }
}
