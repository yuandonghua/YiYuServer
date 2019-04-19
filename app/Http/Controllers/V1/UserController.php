<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @api {PUT} /api/v1/user/userInfo 用户【信息修改】
     * @apiGroup Auth
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 14:09
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {String} nickname 昵称
     * @apiParam (请求参数:) {Integer} sex 男1；女2；未知0
     * @apiParam (请求参数:) {String} photo 头像地址
     * @apiParam (请求参数:) {String} introduce 用户简介
     * 
     * {
     *     "nickname":"提将",
     *     "sex":1,
     *     "photo":"https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/o1pUkbbNmB7bhDAAk4MT6rTVZb6bybHiNW5KY86R.jpeg",
     *     "introduce":"个人介绍"
     * }
     *
     * @apiHeaderExample {x-www-form-urlncode} Header-Example: 请求头部示例：
     * Content-Type: application/json
     * charset=utf-8
     * Authorization: Bearer anEisUMtAbGEbKvlxmNNPliECaph6r7FMAZQpVbv
     *
     * @apiSuccess (返回字段:) {String} status 状态
     * @apiSuccess (返回字段:) {Integer} code  状态码
     * @apiSuccess (返回字段:) {Object} data  code为200时返回的数据包
     * @apiSuccess (返回字段:) {Integer} user_id  用户id
     * @apiSuccess (返回字段:) {Integer} status  0：注销；1：正常
     * @apiSuccess (返回字段:) {Integer} type  2:QQ;3:微信
     * @apiSuccess (返回字段:) {String} nickname  昵称
     * @apiSuccess (返回字段:) {String} photo  头像地址
     * @apiSuccess (返回字段:) {Integer} fans  粉丝数量
     * @apiSuccess (返回字段:) {Integer} star  关注数量
     * @apiSuccess (返回字段:) {Integer} sex  性别
     * @apiSuccess (返回字段:) {String} introduce  个人介绍
     * @apiSuccess (返回字段:) {Integer} art_beat  艺豆
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "id": 7,
     *          "user_id": 20,
     *          "account": "zhangjinyu3",
     *          "type": 1,
     *          "status": 1,
     *          "nickname": "提将",
     *          "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/o1pUkbbNmB7bhDAAk4MT6rTVZb6bybHiNW5KY86R.jpeg",
     *          "fans": 0,
     *          "star": 0,
     *          "sex": 1,
     *          "introduce": "",
     *          "art_beat": 0
     *      }
     *  }
     **/
    public function updateUserInfo(Request $userInfoRequest)
    {
        try {
            $this->userService->updateUserInfo($userInfoRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, []);

    }
}