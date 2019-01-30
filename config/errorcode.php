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
        201 => 'CREATED', //（已创建）请求成功并且服务器创建了新的资源。 
        202 => 'ACCEPTED', // （已接受）  服务器已接受请求，但尚未处理。 
        203 => 'ANOTHER SOURCE', // （返回非授权信息）  服务器已成功处理了请求，但返回的信息可能来自另一来源。 
        304 => 'NOTMODIFIED', // （未修改） 
        400 => 'BADREQUEST', // （错误请求） 服务器不理解请求的语法。 
        401 => 'UNAUTHORIZED', // （未授权） 请求要求身份验证。 对于需要登录的网页，服务器可能返回此响应。
        403 => 'FORBIDDEN', // （禁止） 服务器拒绝请求
        404 => 'NOTFOUND', // （未找到） 服务器找不到请求的网页
        408 => 'CURL TIMEOUT',  //（请求超时) CURL 请求第三方超时
        500 => 'INTERNALSERVERERROR', // （服务器内部错误）  服务器遇到错误，无法完成请求


        /*
         * 以下是艺语APP自定义四位数返回码
         */
        4001 => 'The account number or password is incorrect', // 登录帐号或密码错误
        4002 => 'The account number has been cancelled', // 登录帐号已经被注销
    ],
];