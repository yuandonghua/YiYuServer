<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StorageController extends Controller
{

    /**
     * @api {POST} api/v1/storage/imageUpload 文件【图片上传】
     * @apiGroup Storage
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/02/16 15:00
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {String} image 文件路径
     *
     *
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccess (返回字段:) {String} path  上传后返回的访问地址
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "path": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/4vlQAJ4S2tQz2cVveK23A6Dun60NEChHcg9aPytl.jpeg"
     *      }
     *  }
     **/
    /**
     * 图片上传至腾讯云
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        // 验证是否有上传文件
        if ($request->hasFile('image')) { 
            // 上传文件至云存储
            $path = $request->file('image')->store('image');
            // 验证上传是否成功
            if ($request->file('image')->isValid()) {

                return $this->success(200, ['path' => env('COSV5_URL') . $path]);
            }

            return $this->fail(4022);
        }

        return $this->fail(4021);
    }
}