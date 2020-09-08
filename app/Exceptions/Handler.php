<?php

namespace App\Exceptions;

use App\Http\Controllers\traits\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if (!env('APP_DEBUG', false)) {
            if ($e instanceof MethodNotAllowedHttpException) {
                if ($request->hasHeader('accept') && strtolower($request->header('accept')) === 'application/json') {
                    return ResponseTrait::sendValidationErrors([], t('Method is not allowed for this route.'));
                }
                return response()->view('errors.422', [], 422);
            }
            if ($e instanceof ThrottleRequestsException) {
                if ($request->hasHeader('accept') && strtolower($request->header('accept')) === 'application/json') {
                    return response()->json([
                        'message' => t("Too many attempts.")
                    ], 429);
                }
                return response()->view('errors.429', [], 429);
            }
        }

        return parent::render($request, $e);
    }
}
