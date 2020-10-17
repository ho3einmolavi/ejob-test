<?php

if (!function_exists('_response')) {
    function _response($data , $status = 200 , $message = '')
    {
        $body = [
            'data' => $data ,
            'message' => $message
        ];
        return response()->json($body , $status);
    }
}
