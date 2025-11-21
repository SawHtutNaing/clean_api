<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function handleApiException($request, Throwable $exception)
    {
        // Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found',
                'message' => 'The requested resource does not exist',
            ], 404);
        }

        // Not Found HTTP Exception
        if ($exception instanceof NotFoundHttpException) {

            if ($exception->getPrevious() instanceof ModelNotFoundException) {

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Resource not found.',
                        'error' => 'Model not found for the given ID.',
                    ], 404);
                }
            }

            return response()->json([
                'error' => 'Endpoint not found',
                'message' => 'The requested endpoint does not exist',
            ], 404);
        }

        // Authentication Exception
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'error' => 'Unauthenticated',
                'message' => 'You must be authenticated to access this resource',
            ], 401);
        }

        // Validation Exception
        if ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'The given data was invalid',
                'errors' => $exception->errors(),
            ], 422);
        }

        // Method Not Allowed
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'Method not allowed',
                'message' => 'The HTTP method used is not allowed for this endpoint',
            ], 405);
        }

        // Generic HTTP Exception
        if ($exception instanceof HttpException) {
            return response()->json([
                'error' => 'HTTP Exception',
                'message' => $exception->getMessage() ?: 'An error occurred',
            ], $exception->getStatusCode());
        }

        // Database Query Exception
        if ($exception instanceof \Illuminate\Database\QueryException) {
            return response()->json([
                'error' => 'Database error',
                'message' => config('app.debug')
                    ? $exception->getMessage()
                    : 'A database error occurred',
            ], 500);
        }

        // Default Server Error
        return response()->json([
            'error' => 'Server error',
            'message' => config('app.debug')
                ? $exception->getMessage()
                : 'An unexpected error occurred',
            'trace' => config('app.debug') ? $exception->getTrace() : null,
        ], 500);
    }
}
