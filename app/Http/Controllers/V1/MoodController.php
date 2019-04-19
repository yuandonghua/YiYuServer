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


    /**
     * @api {GET} /api/v1/mood/$id 动态【动态-详情页】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/19 10:00
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
     * @apiSuccess (返回字段:) {Integer} data.user_id 动态所属用户id
     * @apiSuccess (返回字段:) {String} data.mood_content  动态内容
     * @apiSuccess (返回字段:) {String} data.image_url   动态图片
     * @apiSuccess (返回字段:) {Integer} data.comment_num  评论数量
     * @apiSuccess (返回字段:) {Integer} data.thumb_num  点赞数量
     * @apiSuccess (返回字段:) {String} data.created_at  创建时间
     * @apiSuccess (返回字段:) {String} data.nickname  动态发布人的昵称
     * @apiSuccess (返回字段:) {String} data.photo  动态发布人的头像地址
     * @apiSuccess (返回字段:) {String} data.introduce  动态发布人的介绍
     * @apiSuccess (返回字段:) {Object} data.thumbList 点赞列表
     * @apiSuccess (返回字段:) {Integer} data.thumbList.mood_id 动态id  
     * @apiSuccess (返回字段:) {Integer} data.thumbList.user_id  点赞人的用户id
     * @apiSuccess (返回字段:) {Integer} data.thumbList.status  点赞的状态
     * @apiSuccess (返回字段:) {String} data.thumbList.photo  点赞人的用户头像
     * @apiSuccess (返回字段:) {Object} data.commentList 评论列表
     * @apiSuccess (返回字段:) {Integer} data.commentList.id  评论id
     * @apiSuccess (返回字段:) {Integer} data.commentList.mood_id  评论的动态id
     * @apiSuccess (返回字段:) {Integer} data.commentList.user_id  评论的用户id
     * @apiSuccess (返回字段:) {Integer} data.commentList.reply_user_id  被回复的用户id
     * @apiSuccess (返回字段:) {String} data.commentList.content  评论内容
     * @apiSuccess (返回字段:) {String} data.commentList.nickname  评论的用户的昵称
     * @apiSuccess (返回字段:) {String} data.commentList.reply_nickname  被回复的用户昵称
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "id": 2,
     *          "user_id": 20,
     *          "mood_content": "发送心情",
     *          "image_url": "wwww.com.cn,www.com.cn",
     *          "comment_num": 2,
     *          "thumb_num": 1,
     *          "created_at": "2019-04-19 10:52:34",
     *          "nickname": "脱将",
     *          "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/o1pUkbbNmB7bhDAAk4MT6rTVZb6bybHiNW5KY86R.jpeg",
     *          "introduce": "",
     *          "thumbList": [
     *              {
     *                  "id": 3,
     *                  "mood_id": 2,
     *                  "user_id": 20,
     *                  "status": 1,
     *                  "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/o1pUkbbNmB7bhDAAk4MT6rTVZb6bybHiNW5KY86R.jpeg"
     *              }
     *          ],
     *          "commentList": [
     *              {
     *                  "id": 5,
     *                  "mood_id": 2,
     *                  "user_id": 20,
     *                  "reply_user_id": 0,
     *                  "content": "评论1",
     *                  "reply_nickname": null,
     *                  "nickname": "脱将"
     *              },
     *              {
     *                  "id": 6,
     *                  "mood_id": 2,
     *                  "user_id": 20,
     *                  "reply_user_id": 6,
     *                  "content": "评论1",
     *                  "reply_nickname": "金色雨滴",
     *                  "nickname": "脱将"
     *              }
     *          ]
     *      }
     *  }
     **/
    public function show($moodId)
    {
        try {
            $result = $this->moodService->showMood($moodId);
            
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }


    /**
     * @api {GET} /api/v1/moodList 动态【我的动态列表】
     * @apiGroup Mood
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/19 09:09
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
     * @apiSuccess (返回字段:) {Integer} data.id  动态主键id
     * @apiSuccess (返回字段:) {String} data.user_id  
     * @apiSuccess (返回字段:) {String} data.mood_content 动态内容
     * @apiSuccess (返回字段:) {String} data.image_url 图片地址（逗号分隔）
     * @apiSuccess (返回字段:) {String} data.created_at 时间
     * @apiSuccess (返回字段:) {Integer} data.comment_num 评论数量
     * @apiSuccess (返回字段:) {Integer} data.thumb_num 点赞数量
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 2,
     *              "user_id": 20,
     *              "mood_content": "发送心情",
     *              "image_url": "wwww.com.cn,www.com.cn",
     *              "comment_num": 0,
     *              "thumb_num": 0,
     *              "created_at": "2019-04-19 10:52:34"
     *          }
     *      ]
     *  }
     **/
    public function moodList()
    {      
        try {
            $result = $this->moodService->getMoodList();
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }
}