<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

date_default_timezone_set('Asia/Shanghai'); 
class Controller extends BaseController
{   
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /*
     * 成功返回数据
     */
    public function success(int $code = 200, $data = [])
    {
        if ($code < 200 || $code > 300) {
            $this->fail(4011);
        }
        return response()->json([
            'status'  => true,
            'code'    => $code,
            'message' => config('errorcode.code')[(int) $code],
            'data'    => $data,
        ]);
    }

    /*
     * 失败返回数据
     */
    public function fail(int $code, $data = [])
    {
        return response()->json([
            'status'  => false,
            'code'    => $code,
            'message' => config('errorcode.code')[(int) $code],
            'data'    => $data,
        ]);
    }

}
