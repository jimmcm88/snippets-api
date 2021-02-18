<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Could not log you in with those credentials'
                    ]
                ]
            ], 422);
        }

        return response()->json([
            'data' => compact('token')
        ]);
    }
}
