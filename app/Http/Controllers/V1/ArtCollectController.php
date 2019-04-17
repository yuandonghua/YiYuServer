<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ArtCollectService;


class ArtCollectController extends Controller
{

    public function __construct(ArtCollectService $artCollectService)
    {
        $this->artCollectService = $artCollectService;
    }

    /**
     * @api {POST} /api/v1/artInfo/artCollect 作品【收藏作品】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 13:50
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {int} art_id 要收藏的作品id
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "art_id":1
     * }
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "art_id": 1,
     *          "user_id": 18,
     *          "id": 1
     *      }
     *  }
     **/    
    public function artCollect(Request $request)
    {
        $artId = $request->input('art_id', 0);
        $result = $this->artCollectService->createArtCollect($artId);

        return $this->success(200, $result);
    }

    /**
     * @api {POST} /api/v1/artInfo/deleteArtCollect 作品【收藏-取消收藏】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 15:00
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {int} art_id 要收藏的作品id
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "art_id":1
     * }
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
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data":[] 
     *  }
     **/    
    /**
     * 作品收藏-取消收藏
     *
     * @param  app\Models\ArtModel  $art
     * @return \Illuminate\Http\Response
     */
    public function deleteArtCollect(Request $request)
    {
        $artId = $request->input('art_id', 0);
        $result = $this->artCollectService->deleteArtCollect($artId);
        
        return $this->success(200);
    }
}