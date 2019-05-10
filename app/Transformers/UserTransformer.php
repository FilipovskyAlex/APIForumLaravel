<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer
 * @package App\Transformers
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Return basic response structure for user
     * @package League\Fractal\TransformerAbstract
     * @param User $user
     * @return array
     */
    public function transform(User $user) : array
    {
        return [
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $user->avatar(),
        ];
    }
}
