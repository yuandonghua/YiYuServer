<?php


return [

    /*
    |--------------------------------------------------------------------------
    | customized http code
    |--------------------------------------------------------------------------
    |
    | The first number is error type, the second and third number is
    | product type, and it is a specific error code from fourth to
    | sixth.But the success is different.
    |
    */

    'code' => [
        200 => 'SUCCESS', //（成功）服务器已成功处理了请求 
        304 => 'NOTMODIFIED', // （未修改） 
        400 => 'BADREQUEST', // （错误请求） 服务器不理解请求的语法。 
        401 => 'UNAUTHORIZED', // （未授权） 请求要求身份验证。 对于需要登录的网页，服务器可能返回此响应。
        408 => 'CURL TIMEOUT',  //（请求超时) CURL 请求第三方超时
        500 => 'INTERNALSERVERERROR', // （服务器内部错误）  服务器遇到错误，无法完成请求


        /*
         * 以下是艺语APP自定义四位数返回码
         */
        4001 => 'The account number or password is incorrect', // 登录帐号或密码错误
        4002 => 'The account number has been cancelled', // 登录帐号已经被注销



        4011 => 'The code is between 200 and 300', // 
        // 上传范围 4020-4029
        4021 => 'Upload image is empty',
        4022 => 'Upload image is fail',
    ],
];