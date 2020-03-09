<?php

namespace App\Exceptions;

use App\Utils\ErrorCode;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use MongoDB\Exception\InvalidArgumentException;

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
     * Report or log an exception.
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
        if($exception instanceof ValidationException){
            return json_error_response(ErrorCode::$wrongParam,$exception->errors());
        }else if($exception instanceof NotFoundException || $exception instanceof ModelNotFoundException){
            return json_error_response(ErrorCode::$notFound,$exception->getMessage());
        }else if($exception instanceof QueryException){
            return json_error_response(ErrorCode::$unknownError,$exception->getMessage());
        }else if($exception instanceof ExistException){
            return json_error_response(ErrorCode::$exist,$exception->getMessage());
        }else if($exception instanceof InvalidArgumentException){
            return json_error_response(ErrorCode::$wrongFormat,"album_id format invalid");
        }
        return parent::render($request, $exception);
    }
}
