<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\ArtCommentService;


class ArtCommentController extends Controller
{

    public function __construct(ArtCommentService $artCommentService)
    {
        $this->artCommentService = $artCommentService;
    }

    /**
     * @api {POST} /api/v1/artInfo/artComment 作品【评论】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 14:00
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * 
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccess (返回字段:) {Integer} id 主键id
     * @apiSuccess (返回字段:) {Integer} art_id 作品id
     * @apiSuccess (返回字段:) {Integer} user_id 用户id
     * @apiSuccess (返回字段:) {Integer} reply_user_id 被回复用户id（如果没有被回复用户reply_user_id=0）
     * @apiSuccess (返回字段:) {String} content 回复内容
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "art_id": 19,
     *          "content": "回复内容1",
     *          "reply_user_id": 6,
     *          "user_id": 18,
     *          "id": 4
     *      }
     *  }
     **/    
    public function artComment(Request $createCommentRequest)
    {
        $result = $this->artCommentService->createComment($createCommentRequest);

        return $this->success(200, $result);
    }


   
}