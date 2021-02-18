<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\Users\PublicUserTransformer;

class UserController extends Controller
{
    public function show(User $user)
    {
        return fractal()
            ->item($user)
            ->transformWith(new PublicUserTransformer())
            ->toArray();
    }

    public function update(User $user, Request $request)
    {
        // Authorize
        $this->authorize('as', $user); 
        
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'username' => 'required|unique:users,username,' . $request->user()->id,
            'name' => 'required',
            'password' => 'nullable|min:6'
        ]);

        $user->update(
            $request->only('email', 'username', 'name')
        );
    }
}
