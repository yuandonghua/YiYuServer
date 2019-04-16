<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Services\BannerService;


class BannerController extends Controller
{

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * @api {GET} /api/v1/banner/list 轮播图【列表】
     * @apiGroup Banner
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 17:50
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
     * @apiSuccess (返回字段:) {String} image_url 图片地址
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 1,
     *              "order_num": 1,
     *              "image_url": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/DzYoe87AMfk3cJ4Ew8c3WPqJoT6kBw7cGoOkCjge.jpeg",
     *              "status": 1
     *          },
     *          {
     *              "id": 2,
     *              "order_num": 2,
     *              "image_url": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg",
     *              "status": 1
     *          }
     *      ]
     *  }
     **/    
    public function bannerList()
    {
        $result = $this->bannerService->getBannerList();

        return $this->success(200, $result);
    }


   
}