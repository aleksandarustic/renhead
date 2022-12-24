<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService implements AuthServiceInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function login(array $data) : string
    {
        if (!Auth::guard('web')->attempt($data)) {
            abort(401, "Email & Password does not match with our record.");
        }

        $user = User::where('email', $data['email'])->first();

        return $user->createToken('auth-token', [$user->type])->plainTextToken;
    }

    /**
     * @param array $data
     * @return string
     */
    public function register(array $data) : string
    {
        $user = User::create($data);

        return $user->createToken('auth-token', [$user->type])->plainTextToken;
    }


}
