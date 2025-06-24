<?php

use Illuminate\Http\JsonResponse;


if (!function_exists('returnJsonResponse')) {

    function returnJsonResponse(
        string $status = 'success',
        string $message = '',
        $data = null,
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }
}
