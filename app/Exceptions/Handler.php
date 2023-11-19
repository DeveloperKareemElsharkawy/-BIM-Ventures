<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{

    /**
     * @param $request
     * @param ValidationException $exception
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return response()->json([
            'status' => false,
            'code' => $request->ajax() ? 200 : 422,
            'message' => $exception->getMessage(),
            'errors' => $exception->errors(),
        ], $request->ajax() ? 200 : 422);
    }

    /**
     * @param $request
     * @param AuthenticationException $exception
     * @return RedirectResponse|JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'code' => 401,
                'message' => $exception->getMessage(),
                'data' => null,
                'errors' => [],
            ], 401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->json([
                'status' => false,
                'code' => 403,
                'message' => $e->getMessage(),
                'data' => null,
                'errors' => [],
            ], 403);
        });
    }

}
