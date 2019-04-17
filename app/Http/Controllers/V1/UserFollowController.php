<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UserFollowService;

class UserFollowController extends Controller
{

    public function __construct(UserFollowService $userFollowService)
    {
        $this->userFollowService = $userFollowService;
    }

    /**
     * @api {GET} /api/v1/follow/follow 关注【关注列表or粉丝列表】
     * @apiGroup Follow
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 15:50
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {String} follow （关注时follow=follow，粉丝时follow=fans）
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "follow":"follow"
     * }
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccess (返回字段:) {String} photo 头像地址
     * @apiSuccess (返回字段:) {String} nickname 昵称
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "user_id": 18,
     *              "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg",
     *              "nickname": "黑天使"
     *          }
     *      ]
     *  }
     **/    
    public function followList(Request $request)
    {
        $follow = $request->input('follow');
        $result = $this->userFollowService->getUserFollowList($follow);

        return $this->success(200, $result);
    }


    /**
     * @api {POST} /api/v1/follow/createFollow 关注【关注用户】
     * @apiGroup Follow
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 16:50
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {Integer} user_id 用户id
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "user_id":6
     * }
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccess (返回字段:) {Integer} id 主键id
     * @apiSuccess (返回字段:) {Integer} follow_user_id 被关注的用户
     * @apiSuccess (返回字段:) {Integer} user_id 
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "follow_user_id": 6,
     *          "user_id": 18,
     *          "status": 1,
     *          "id": 7
     *      }
     *  }
     **/     
    public function createFollow(Request $createFollowRequest)
    {
        $userId = $createFollowRequest->input('user_id');
        $result = $this->userFollowService->createUserFollow($userId);

        return $this->success(200, $result);
    }



    /**
     * @api {POST} /api/v1/follow/deleteFollow 关注【取消关注用户】
     * @apiGroup Follow
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 17:15
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {Integer} user_id 用户id
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "user_id":6
     * }
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {Integer} code 状态码
     * @apiSuccess (返回字段:) {String} message  提示信息
     * @apiSuccess (返回字段:) {Object} data  statusCode为200时返回的数据包
     * @apiSuccess (返回字段:) {Integer} id 主键id
     * @apiSuccess (返回字段:) {Integer} follow_user_id 被关注的用户
     * @apiSuccess (返回字段:) {Integer} user_id 
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *      }
     *  }
     **/
    public function deleteFollow(Request $deleteFollowRequest)
    {
        $userId = $deleteFollowRequest->input('user_id');
        $result = $this->userFollowService->deleteUserFollow($userId);

        return $this->success(200, $result);
    }

}