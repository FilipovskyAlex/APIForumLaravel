<?php

namespace App\Policies;

use App\Topic;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class TopicPolicy
 * @package App\Policies
 */
class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic) : bool
    {
        return $user->onwsTopic($topic);
    }

    /**
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function delete(User $user, Topic $topic) : bool
    {
        return $user->onwsTopic($topic);
    }
}
