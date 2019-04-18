<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\MoodThumbService;
use App\Models\MoodThumbModel;

class MoodThumbController extends Controller
{
    public function __construct(MoodThumbService $moodThumbService)
    {
        $this->moodThumbService = $moodThumbService;
    }
    /**
     * @api {POST} /api/v1/moodThumb 动态【点赞】
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
     * @apiParam (请求参数:) {Integer} mood_id 动态id
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *     "mood_id":1
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
    public function store(Request $createMoodThumbRequest)
    {      
        try {
            $this->moodThumbService->createMoodThumb($createMoodThumbRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }


    /**
     * @api {DELETE} /api/v1/moodThumb/$id 动态【取消点赞】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 17:12
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
            $this->moodThumbService->deleteMoodThumb($moodId);
            
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }


    /**
     * @api {GET} /api/v1/moodThumb/list 动态【点赞列表】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 17:39
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {Integer} mood_id 动态id
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *     "mood_id":1
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
     * @apiSuccess (返回字段:) {Integer} data.user_id  点赞用户id
     * @apiSuccess (返回字段:) {Integer} data.mood_id  点赞的动态id
     * @apiSuccess (返回字段:) {String} data.nickname  用户昵称
     * @apiSuccess (返回字段:) {String} data.photo  用户头像地址
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "user_id": 20,
     *              "nickname": "脱将",
     *              "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/o1pUkbbNmB7bhDAAk4MT6rTVZb6bybHiNW5KY86R.jpeg",
     *              "mood_id": 1
     *          }
     *      ]
     *  }
     **/
    public function moodThumbList(Request $request)
    {
        $moodId = $request->input('mood_id');
        $result = $this->moodThumbService->getMoodThumbList($moodId);
            
       
        return $this->success(200, $result);
    }
    
}