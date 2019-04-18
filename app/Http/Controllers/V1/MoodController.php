<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\MoodService;
use App\Models\MoodModel;

class MoodController extends Controller
{
    public function __construct(MoodService $moodService)
    {
        $this->moodService = $moodService;
    }

    /**
     * @api {POST} /api/v1/mood 动态【创建】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 09:09
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {String} mood_content 动态内容
     * @apiParam (请求参数:) {String} image_url 图片url（用逗号分隔）
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *     "mood_content":"发送心情",
     *     "image_url":"wwww.com.cn,www.com.cn"
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
     * @apiSuccess (返回字段:) {Integer} data.id  动态主键id
     * @apiSuccess (返回字段:) {String} data.mood_content  动态内容
     * @apiSuccess (返回字段:) {String} data.image_url 图片url（用逗号分隔）
     * @apiSuccess (返回字段:) {Integer} data.user_id 发布动态的用户id
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "mood_content": "发送心情",
     *          "image_url": "wwww.com.cn,www.com.cn",
     *          "user_id": 20,
     *          "id": 1
     *      }
     *  }
     **/
    public function store(Request $createMoodRequest)
    {      
        try {
            $result = $this->moodService->createMood($createMoodRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }

    /**
     * @api {DELETE} /api/v1/mood/$id 动态【删除】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 18:00
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
     *      "data": []
     *  }
     **/
    public function destroy($moodId)
    {
        try {
            $this->moodService->deleteMood($moodId);
            
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }


}