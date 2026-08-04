<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    /**
     * Display the API health status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Business Service API is running.',
            'data' => [
                'version' => '1.0.0',
                'framework' => 'Laravel',
                'php_version' => PHP_VERSION,
                'timestamp' => now()->toIso8601String(),
            ]
        ]);
    }
}
