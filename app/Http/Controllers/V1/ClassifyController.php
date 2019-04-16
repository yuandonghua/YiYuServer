<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ClassifyService;


class ClassifyController extends Controller
{

    public function __construct(ClassifyService $classifyService)
    {
        $this->classifyService = $classifyService;
    }

    /**
     * @api {GET} classify/list 画风分类【列表】
     * @apiGroup Classify
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 16:09
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @paiParam (请求字段:) {Integer} pid 父id(如果获取一级列表，pid=0；如果是二级列表，pid=【一级分类的主键id】)
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
     * @apiSuccess (返回字段:) {String} class_name 分类名称
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 7,
     *              "pid": 0,
     *              "class_name": "水彩",
     *              "order_num": 1
     *          },
     *          {
     *              "id": 6,
     *              "pid": 0,
     *              "class_name": "油画",
     *              "order_num": 2
     *          }
     *      ]
     *  }
     **/    
    public function classifyList(Request $request)
    {
        $pid = $request->input('pid', 0);
        $result = $this->classifyService->getclassifyList($pid);

        return $this->success(200, $result);
    }


   
}