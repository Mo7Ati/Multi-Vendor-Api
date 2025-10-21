<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;

class ExceptionHandler
{
    /**
     * Handle API exceptions.
     *
     * @param Throwable $e
     * @return JsonResponse
     */
    public function handleApiException(Throwable $e): JsonResponse
    {
        // Log detailed exception if needed
        Log::error('API Exception: ' . $e->getMessage(), [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        // Handle Laravel Authentication Exceptions
        if ($e instanceof AuthenticationException || $e->getMessage() == 'Route [login] not defined.')
            return $this->apiResponse($e, trans('message.unauthenticated'), 401, 401);


        if ($e instanceof AuthorizationException)
            return $this->apiResponse($e, trans('coreback::message.unauthorized'), 403, 403);


        // Handle other exceptions
        if ($e instanceof NotFoundHttpException)
            return $this->apiResponse($e, trans('coreback::message.not_found'), 404, 404);


        if ($e instanceof ValidationException)
            return $this->apiResponse($e, $e->getMessage(), 422, 422);

        // Handle generic exceptions
        return $this->apiResponse($e, $e->getMessage(), 500, 500);
    }

    /**
     * Create a standardized API error response.
     *
     * @param Throwable $e
     * @param string $message
     * @param int $code
     * @param int $codeResponse
     * @return JsonResponse
     */
    public function apiResponse($e, $message, $code, $codeResponse = 200): JsonResponse
    {
        $response = [
            'status' => false,
            'data' => null,
            'error_code' => $code,
            'message' => $message,
        ];

        // Add debug information in development environment
        if (app()->environment('local', 'development')) {
            $response['debug'] = [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }

        return response()->json($response, $codeResponse);
    }
}
