<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\UserClassifyService;

class UserClassifyController extends Controller
{
    public function __construct(UserClassifyService $userClassifyService)
    {
        $this->userClassifyService = $userClassifyService;
    }

    /**
     * @api {GET} /api/v1/userClassify 个人分类【获取用户作品分类列表】
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
     * @apiParam (请求参数:) {String} user_id 用户id
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "user_id":7
     * }
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
    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $result = $this->userClassifyService->getUserClassifyInfoByUserId($userId);

        return $this->success(200, $result);
    }



    /**
     * @api {POST} /api/v1/userClassify 个人分类【创建分类】
     * @apiGroup UserClassify
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 17:57
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {String} class_name 分类名称
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "class_name":"分类名称"
     * }
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
     *      "data": {
     *          "id": 10,
     *          "user_id": 18,
     *          "class_name": "啥1",
     *          "number": 0,
     *          "image_url": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg"
     *      }
     *  }
     **/    
    public function store(Request $createUserClassifyRequest)
    {
        
        try {
            $result = $this->userClassifyService->createUserClassify($createUserClassifyRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }

    /**
     * @api {PUT} /api/v1/userClassify/$id 个人分类【修改分类】
     * @apiGroup UserClassify
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 17:57
     *
     * Email:363626256@qq.com
     * --------------------------------------
     * @apiParam (请求参数:) {String} class_name 分类名称
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "class_name":"分类名称"
     * }
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
     *      "data": {
     *          "id": 10,
     *          "user_id": 18,
     *          "class_name": "啥1",
     *          "number": 0,
     *          "image_url": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg"
     *      }
     *  }
     **/ 
    public function update(Request $updateUserClassifyRequest, $id)
    {
        try {
            $result = $this->userClassifyService->updateUserClassify($updateUserClassifyRequest->all(), $id);
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }

    /**
     * @api {DELETE} /api/v1/userClassify/$id 个人分类【删除分类并删除分类内的作品】
     * @apiGroup UserClassify
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 17:57
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
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": []
     *  }
     **/ 
   
    public function destroy($id)
    {
        
        try {
            $result = $this->userClassifyService->deleteUserClassify($id);
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }
}