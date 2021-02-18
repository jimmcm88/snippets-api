<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\UserTransformer;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::create($request->only('email','name', 'username', 'password'));

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer())
            ->toArray();
    }
}
