<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Services\UserClassifyService;

class UserClassifyController extends Controller
{
    public function __construct(UserClassifyService $userClassifyService)
    {
        $this->userClassifyService = $userClassifyService;
    }

    /**
     * @api {GET} userClassify/classifyInfo 个人分类【获取用户作品分类列表】
     * @apiGroup UserClassify
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 15:57
     *
     * Email:363626256@qq.com
     * --------------------------------------
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
     * @apiSuccess (返回字段:) {Integer} id 分类主键id
     * @apiSuccess (返回字段:) {Integer} user_id 用户id
     * @apiSuccess (返回字段:) {String} class_name 分类名称
     * @apiSuccess (返回字段:) {String} image_url 分类图片地址
     * @apiSuccess (返回字段:) {Integer} number 分类里作品的数量
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 1,
     *              "user_id": 18,
     *              "class_name": "大写意山水",
     *              "number": 0,
     *              "image_url": "www.3333.com"
     *          },
     *          {
     *              "id": 2,
     *              "user_id": 18,
     *              "class_name": "工笔花鸟",
     *              "number": 0,
     *              "image_url": "www.3333.com"
     *          }
     *      ]
     *  }
     **/    
    public function getUserClassifyInfo()
    {
        $userId = \Auth::user()->id;
        $result = $this->userClassifyService->getUserClassifyInfoByUserId($userId);

        return $this->success(200, $result);
    }
}