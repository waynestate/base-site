<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @return void
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        // Add custom errors when debug is not enabled
        if (config('app.debug') == false) {
            if ($e instanceof HttpException && View::exists('errors.'.$e->getStatusCode())) {
                return response(view('errors.'.$e->getStatusCode(), compact('request')), $e->getStatusCode());
            } else {
                return response(view('errors.500', compact('request')), 500);
            }
        }

        return parent::render($request, $e);
    }
}
