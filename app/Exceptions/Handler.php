<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use InvalidArgumentException;
use Exception;
use ErrorException;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->renderable(function (InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        });

        $this->renderable(function (ErrorException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        });

        $this->renderable(function (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ? $e->getCode() : 400);
        });
    }
}
