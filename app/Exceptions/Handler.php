<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
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

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, Request $request) {
            app('log')->error($e->getTraceAsString(), [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'exception' => $e,
            ]);

            $statusCode = FlattenException::createFromThrowable($e)->getStatusCode();
            $url = sprintf('/500?statusCode=%d', $statusCode);

            return redirect($url);
        });

        $this->reportable(function (Throwable $e) {
            // reportable如果不做處理，預設的laravel handler會寫Error log
            // 這樣會與render部分的Error log重複撰寫，讓錯誤率高了一倍
            // 故此處回傳false，不寫入預設的Error log
            return false;
        });
    }
}
