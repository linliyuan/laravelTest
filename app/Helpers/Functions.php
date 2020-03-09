<?php


use App\Utils\ErrorCode;

if (!function_exists('json_error_response')) {

    function json_error_response($code, $message = null, $name = null, $details = null)
    {
        $defaultMessage = [
            ErrorCode::$wrongParam => [
                "name" => "Wrong Param",
                "message" => "Wrong Param",
            ],
            ErrorCode::$notFound => [
                "name" => "RESOURCE_NOT_FOUND",
                "message" => "Not Found",
            ],
            ErrorCode::$unknownError  => [
                "name" => "INTERNAL_SERVER_ERROR",
                "message" => "Internal Server Error",
            ],
            ErrorCode::$exist => [
                "name" => "DATA IS EXIST",
                "message" => "DATA IS EXIST"
            ]
        ];

        if (is_null($message)) {
            if (isset($defaultMessage[$code])) {
                $message = $defaultMessage[$code]['message'];
            }
        }

        if (is_null($name)) {
            if (isset($defaultMessage[$code])) {
                $name = $defaultMessage[$code]['name'];
            }
        }

        $result = [
            'errCode' => $code,
            'message' => $message,
        ];

        if ($details) {
            $result['details'] = $details;
        }

        return response($result);
    }
}
