<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterController
 * @package App\Http\Controllers
 */
class RegisterController extends Controller
{
    /**
     * Simply register user and return json array with some user data using Fractal
     * @param RegisterUserRequest $request
     * @return array
     */
    public function register(RegisterUserRequest $request) : array
    {
        $user = new User;

        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));

        $user->save();

        // can use return fractal($books, new BookTransformer())->toArray() instead
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
