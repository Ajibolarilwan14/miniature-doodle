<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!($user) || (!(Hash::check($request->password, $user->password))))
        {
            return $this->sendError([], "Whoops, that credentials does not match our records!", Response::HTTP_BAD_REQUEST);
        }

        return $this->sendResponse([
            'token' => $user->createToken('miniaturedoodle20240303')->plainTextToken
        ], "Login Successfully");
    }
}