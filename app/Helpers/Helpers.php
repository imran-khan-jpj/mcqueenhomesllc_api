<?php 


namespace App\Helpers;


class Helpers {
    public static function response($status = "", $msg = "", $data = "", $statusCode = ""){
        return response()->json(['status' => $status, 'msg' => $msg, 'data' => $data], $statusCode);
    }
}