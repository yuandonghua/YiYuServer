<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\MoodCommentService;
use App\Models\MoodCommentModel;

class MoodCommentController extends Controller
{
    public function __construct(MoodCommentService $moodCommentService)
    {
        $this->moodCommentService = $moodCommentService;
    }

    /**
     * @api {POST} /api/v1/moodComment 动态【添加评论】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 17:09
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {String} content 动态评论内容
     * @apiParam (请求参数:) {Integer} mood_id 动态主键id
     * @apiParam (请求参数:) {Integer} reply_user_id 回复用户的id（如果没有reply_user_id=0）
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *     "mood_id":1,
     *     "reply_user_id":0,
     *     "content":"评论1"
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
     *      "data": []
     *  }
     **/
    public function store(Request $createMoodCommentRequest)
    {      
        try {
            $this->moodCommentService->createMoodComment($createMoodCommentRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }



    /**
     * @api {DELETE} /api/v1/moodComment/$id 动态【删除评论】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 17:47
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
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
     * 作品
     *
     * @param  app\Models\ArtModel  $art
     * @return \Illuminate\Http\Response
     */
     public function destroy(MoodCommentModel $moodComment)
     {
        try {
            $this->moodCommentService->deleteMoodComment($moodComment);
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
     }
}