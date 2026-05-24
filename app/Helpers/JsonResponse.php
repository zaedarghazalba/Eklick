<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse as HttpJsonResponse;

class JsonResponse
{
    /**
     * Return success JSON response
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return HttpJsonResponse
     */
    public static function success(string $message, $data = null, int $statusCode = 200): HttpJsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Return error JSON response
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return HttpJsonResponse
     */
    public static function error(string $message, int $statusCode = 400, $errors = null): HttpJsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }
}
