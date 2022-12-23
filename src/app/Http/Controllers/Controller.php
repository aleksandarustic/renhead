<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param string $message
     * @param bool $success
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function message(string $message, bool $success = true, int $status = 200)
    {
        return response()->json([
            'message' => $message,
            'success' => $success
        ], $status);
    }
}
