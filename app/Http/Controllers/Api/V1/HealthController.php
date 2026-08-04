<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    use ApiResponse;

    /**
     * Display the API health status.
     */
    public function index(): JsonResponse
    {
        return $this->success([
            'version' => '1.0.0',
            'framework' => 'Laravel',
            'php_version' => PHP_VERSION,
            'timestamp' => now()->toIso8601String(),
        ], 'Business Service API is running.');
    }
}
