<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param AuthServiceInterface $authService
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(AuthServiceInterface $authService, RegisterRequest $request)
    {
        $token = $authService->register(Arr::except($request->validated(), 'confirmation_password'));

        return response()->json([
            'message' => "User successfully registered",
            'token' => $token
        ]);
    }

    /**
     * @param AuthServiceInterface $authService
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthServiceInterface $authService, LoginRequest $request)
    {
        $token = $authService->login($request->validated());

        return response()->json([
            'token' => $token,
            'message' => "User logged in successfully"
        ]);
    }
}
