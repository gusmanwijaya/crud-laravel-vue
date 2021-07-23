<?php

namespace App\Http\Controllers\API;

class ResponseJson 
{
    protected static $response = [
        'meta' => [
            'statusCode' => 200,
            'status' => 'success',
            'message' => null
        ],
        'data' => null
    ];

    public static function success($data = null, $message = null)
    {
        self::$response['data'] = $data;
        self::$response['meta']['message'] = $message;

        return response()->json(self::$response, self::$response['meta']['statusCode']);
    }

    public static function error($data = null, $message = null, $statusCode = 400)
    {
        self::$response['meta']['statusCode'] = $statusCode;
        self::$response['meta']['status'] = "error";
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['statusCode']);
    }

}

?>