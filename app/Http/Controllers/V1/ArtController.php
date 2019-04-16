<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreArtRequest;
use App\Http\Requests\UpdateArtRequest;
use App\Models\ArtModel;
use App\Services\ArtService;


class ArtController extends Controller
{
    public function __construct(ArtService $artService)
    {
        $this->middleware('jwt.auth', ['except' => ['index']]);
        $this->artService = $artService;
    }



    /**
     * 作品列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        dd('art.index');
    }



    /**
     * @api {POST} /api/v1/art 作品【创建】
     * @apiGroup Art
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
     * @apiParam (请求参数:) {String} title 标题
     * @apiParam (请求参数:) {Integer} publisher_user_id 发布人
     * @apiParam (请求参数:) {Integer} style_classify_id   风格分类id
     * @apiParam (请求参数:) {Integer} user_classify_id   个人作品集分类id
     * @apiParam (请求参数:) {Integer} width   宽(mm)
     * @apiParam (请求参数:) {Integer} height   高(mm)
     * @apiParam (请求参数:) {Integer} long  长(mm)
     * @apiParam (请求参数:) {Integer} shape   1:平面;2:立体
     * @apiParam (请求参数:) {String} main_image   主图地址
     * @apiParam (请求参数:) {Object} art_info_model 作品信息
     * @apiParam (请求参数:) {String} art_info_model.author 作者
     * @apiParam (请求参数:) {String} art_info_model.image_info 作品图片地址（逗号分隔）
     * @apiParam (请求参数:) {String} art_info_model.create_year 创建时间
     * @apiParam (请求参数:) {String} art_info_model.introduce 作品介绍
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "title":"标题1911",
     *   "pulisher_user_id":1,
     *   "classify_id":1,
     *   "user_classify_id":1,
     *   "width":34,
     *   "height":11,
     *   "long":23,
     *   "shape":1,
     *   "main_image":"www.1111.com",
     *   "art_info_model":{
     *     "author":"zhangsan",
     *     "image_info":"www.111.com11111",
     *     "create_year":"20191",
     *     "introduce":"jieshao111111"
     *   }
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
     *      "data": {
     *          "id": 19,
     *          "title": "标题1911",
     *          "pulisher_user_id": 1,
     *          "classify_id": 1,
     *          "user_classify_id": 1,
     *          "width": 34,
     *          "height": 11,
     *          "long": 23,
     *          "review": 0,
     *          "shape": 1,
     *          "main_image": "www.1111.com",
     *          "art_info_model": {
     *              "id": 7,
     *              "art_id": 19,
     *              "author": "zhangsan",
     *              "image_info": "www.111.com11111",
     *              "create_year": "20191",
     *              "introduce": "jieshao111111"
     *          }
     *      }
     *  }
     **/

    /**
     * 作品创建
     * @param App\Http\Requests\UpdateArtRequest $createArtDataRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtRequest $createArtDataRequest)
    {
        
        try {
            $result = $this->artService->createArt($createArtDataRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }

    
    /**
     * @api {GET} /api/v1/art/$id 作品【获取单条记录】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 10:10
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
     * @apiSuccess (返回字段:) {Integer} id 作品主键id
     * @apiSuccess (返回字段:) {String} title 标题
     * @apiSuccess (返回字段:) {Integer} publisher_user_id 发布人
     * @apiSuccess (返回字段:) {Integer} style_classify_id   风格分类id
     * @apiSuccess (返回字段:) {Integer} user_classify_id   个人作品集分类id
     * @apiSuccess (返回字段:) {Integer} width   宽(mm)
     * @apiSuccess (返回字段:) {Integer} height   高(mm)
     * @apiSuccess (返回字段:) {Integer} long  长(mm)
     * @apiSuccess (返回字段:) {Integer} shape   1:平面;2:立体
     * @apiSuccess (返回字段:) {String} main_image   主图地址
     * @apiSuccess (返回字段:) {Object} art_info_model 作品信息
     * @apiSuccess (返回字段:) {Integer} art_info_model.id 作品详细信息id
     * @apiSuccess (返回字段:) {Integer} art_info_model.art_id 作品主键id
     * @apiSuccess (返回字段:) {String} art_info_model.author 作者
     * @apiSuccess (返回字段:) {String} art_info_model.image_info 作品图片地址（逗号分隔）
     * @apiSuccess (返回字段:) {String} art_info_model.create_year 创建时间
     * @apiSuccess (返回字段:) {String} art_info_model.introduce 作品介绍
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "id": 19,
     *          "title": "标题1911",
     *          "pulisher_user_id": 1,
     *          "classify_id": 1,
     *          "user_classify_id": 1,
     *          "width": 34,
     *          "height": 11,
     *          "long": 23,
     *          "review": 0,
     *          "shape": 1,
     *          "main_image": "www.1111.com",
     *          "art_info_model": {
     *              "id": 7,
     *              "art_id": 19,
     *              "author": "zhangsan",
     *              "image_info": "www.111.com11111",
     *              "create_year": "20191",
     *              "introduce": "jieshao111111"
     *          }
     *      }
     *  }
     **/

    /**
     * 作品-获取单条记录
     *
     * @param  app\Models\ArtModel  $art
     * @return \Illuminate\Http\Response
     */
    public function show(ArtModel $art)
    {
        $art->artInfoModel;

        return $this->success(200, $art);
    }


    /**
     * @api {PUT} /api/v1/art/$id 作品【修改】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 11:30
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {Integer} id 作品主键id
     * @apiParam (请求参数:) {String} title 标题
     * @apiParam (请求参数:) {Integer} publisher_user_id 发布人
     * @apiParam (请求参数:) {Integer} style_classify_id   风格分类id
     * @apiParam (请求参数:) {Integer} user_classify_id   个人作品集分类id
     * @apiParam (请求参数:) {Integer} width   宽(mm)
     * @apiParam (请求参数:) {Integer} height   高(mm)
     * @apiParam (请求参数:) {Integer} long  长(mm)
     * @apiParam (请求参数:) {Integer} shape   1:平面;2:立体
     * @apiParam (请求参数:) {String} main_image   主图地址
     * @apiParam (请求参数:) {Object} art_info_model 作品信息
     * @apiParam (请求参数:) {String} art_info_model.id 作者详情id
     * @apiParam (请求参数:) {String} art_info_model.author 作者
     * @apiParam (请求参数:) {String} art_info_model.image_info 作品图片地址（逗号分隔）
     * @apiParam (请求参数:) {String} art_info_model.create_year 创建时间
     * @apiParam (请求参数:) {String} art_info_model.introduce 作品介绍
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "id":19,
     *   "title":"标题1911",
     *   "pulisher_user_id":1,
     *   "classify_id":1,
     *   "user_classify_id":1,
     *   "width":34,
     *   "height":11,
     *   "long":23,
     *   "shape":1,
     *   "main_image":"www.1111.com",
     *   "art_info_model":{
     *     "id":7,
     *     "author":"zhangsan",
     *     "image_info":"www.111.com11111",
     *     "create_year":"20191",
     *     "introduce":"jieshao111111"
     *   }
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
     *      "data": {
     *          "id": 19,
     *          "title": "标题1911",
     *          "pulisher_user_id": 1,
     *          "classify_id": 1,
     *          "user_classify_id": 1,
     *          "width": 34,
     *          "height": 11,
     *          "long": 23,
     *          "review": 0,
     *          "shape": 1,
     *          "main_image": "www.1111.com",
     *          "art_info_model": {
     *              "id": 7,
     *              "art_id": 19,
     *              "author": "zhangsan",
     *              "image_info": "www.111.com11111",
     *              "create_year": "20191",
     *              "introduce": "jieshao111111"
     *          }
     *      }
     *  }
     **/

    /**
     * 作品修改.
     *
     * @param  use App\Http\Requests\UpdateArtRequest  $updateArtDataRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateArtRequest $updateArtDataRequest, $id)
    {
        try {
            $updateArtDataRequest->merge(['id' => $id]);
            $result = $this->artService->updateArt($updateArtDataRequest->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200, $result);
    }


    /**
     * @api {DELETE} /api/v1/art/$id 作品【删除】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/16 13:47
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
    public function destroy(ArtModel $art)
    {
        
        try {
            $art->delete();
            $art->artInfoModel()->delete();
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
    }
}
