<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create(Arr::except($request->validated(), 'confirmation_password'));

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('auth-token', [$user->type])->plainTextToken
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::guard('web')->attempt($request->validated())) {
            abort(401, "Email & Password does not match with our record.");
        }

        $user = User::where('email', $request->get('email'))->first();

        return response()->json([
            'token' => $user->createToken('auth-token', [$user->type])->plainTextToken,
            'message' => "User Logged In Successfully"
        ]);
    }
}
