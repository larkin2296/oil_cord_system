<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Traits\ResultTrait;
use App\Traits\ExceptionTrait;

class Handler extends ExceptionHandler
{
    use ResultTrait, ExceptionTrait;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if(env('APP_DEBUG')){
            dd($exception);
        }
        $results = [];

        /*验证规则*/
        if( $exception instanceof ValidationException ) {
            $message = '系统出错';
            if( $errors = $exception->errors() ) {
                foreach( $errors as $error ) {
                    $message = $error[0];
                    break;
                }
            }

            $results = array_merge($this->results, [
                'message' => $message,
            ]);
        }

        if( !$results ) {
            /*处理通用异常*/
            $results = array_merge($this->results, [
                'message' => $this->handler($exception),
            ]);
        }

        /*返回json*/
        if( request()->format() == 'json' ) {
            return response()->json($results);
        }

        return parent::render($request, $exception);
    }
}
