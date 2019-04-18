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
        $this->middleware('jwt.auth', ['except' => ['artList', 'show']]);
        $this->artService = $artService;
    }


    /**
     * @api {GET} /api/v1/artList 作品【首页-作品列表】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/17 06:01
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {int} searchWhere 搜索条件(说明：如果点击《关注》按钮，searchWhere='follow'；如果点击《推荐》按钮，searchWhere='recommend')
     *
     *
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "searchWhere":1
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
     * @apiSuccess (返回字段:) {Integer} data.id  作品id
     * @apiSuccess (返回字段:) {String} data.photo 作品发布人头像地址
     * @apiSuccess (返回字段:) {String} data.nickname  作品发布人昵称
     * @apiSuccess (返回字段:) {String} data.introduce  作品发布人的简介
     * @apiSuccess (返回字段:) {String} data.class_name  分类名称
     * @apiSuccess (返回字段:) {Integer} data.long   作品长度
     * @apiSuccess (返回字段:) {Integer} data.width  作品宽度
     * @apiSuccess (返回字段:) {Integer} data.height   作品高度
     * @apiSuccess (返回字段:) {Integer} data.shape  作品形状：1平面；2立体
     * @apiSuccess (返回字段:) {String} data.create_year  作品创建年份
     * @apiSuccess (返回字段:) {Integer} data.follow_num  关注量
     * @apiSuccess (返回字段:) {Integer} data.comment_num  评论量
     * @apiSuccess (返回字段:) {String} data.main_image  作品主图地址
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 28,
     *              "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg",
     *              "nickname": "黑天使",
     *              "introduce": "个人介绍",
     *              "class_name": "写意",
     *              "long": 23,
     *              "width": 34,
     *              "height": 11,
     *              "shape": 1,
     *              "main_image": "www.1111.com",
     *              "title": "标题1",
     *              "create_year": "2018",
     *              "follow_num": 0,
     *              "comment_num": 0
     *          },
     *          {
     *              "id": 26,
     *              "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg",
     *              "nickname": "黑天使",
     *              "introduce": "个人介绍",
     *              "class_name": "写意",
     *              "long": 23,
     *              "width": 34,
     *              "height": 11,
     *              "shape": 1,
     *              "main_image": "www.1111.com",
     *              "title": "标题1",
     *              "create_year": "2018",
     *              "follow_num": 0,
     *              "comment_num": 0
     *          }
     *      ]
     *  }
     **/
    /**
     * 作品列表
     *
     * @return \Illuminate\Http\Response
     */
    public function artList(Request $request)
    {
        $result = $this->artService->getArtList($request->input('searchWhere', 'recommend'));
        
        return $this->success(200, $result);
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
     *   "create_year":"20191",
     *   "main_image":"www.1111.com",
     *   "art_info_model":{
     *     "author":"zhangsan",
     *     "image_info":"www.111.com11111",
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
     *          "create_year": "20191",
     *          "art_info_model": {
     *              "id": 7,
     *              "art_id": 19,
     *              "author": "zhangsan",
     *              "image_info": "www.111.com11111",
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
     * @apiSuccess (返回字段:) {String} class_name 分类名称
     * @apiSuccess (返回字段:) {String} photo   发布人的头像地址
     * @apiSuccess (返回字段:) {String} nickname   发布人的昵称
     * @apiSuccess (返回字段:) {String} introduce   发布人的介绍
     * @apiSuccess (返回字段:) {Integer} width   宽(mm)
     * @apiSuccess (返回字段:) {Integer} height   高(mm)
     * @apiSuccess (返回字段:) {Integer} long  长(mm)
     * @apiSuccess (返回字段:) {Integer} shape   1:平面;2:立体
     * @apiSuccess (返回字段:) {String} main_image   主图地址
     * @apiSuccess (返回字段:) {String} author 作者
     * @apiSuccess (返回字段:) {String} image_info 作品图片地址（逗号分隔）
     * @apiSuccess (返回字段:) {String} create_year 创建时间
     * @apiSuccess (返回字段:) {String} art_introduce 作品介绍
     * @apiSuccess (返回字段:) {Integer} collect_num 作品收藏量
     * @apiSuccess (返回字段:) {Integer} comment_num 作品评论量
     * @apiSuccess (返回字段:) {Object} collect 收藏此作品的用户头像
     * @apiSuccess (返回字段:) {Integer} collect.user_id 收藏此作品的用户id
     * @apiSuccess (返回字段:) {String} collect.photo 收藏此作品的用户头像地址
     * @apiSuccess (返回字段:) {Object} commentContent 评论列表
     * @apiSuccess (返回字段:) {Integer} user_id 评论用户id
     * @apiSuccess (返回字段:) {Integer} reply_user_id 回复用户的id
     * @apiSuccess (返回字段:) {String} nickname 评论用户的昵称
     * @apiSuccess (返回字段:) {String} reply_nickname 回复用户的昵称
     * @apiSuccess (返回字段:) {String} content 评论内容
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": {
     *          "id": 19,
     *          "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg",
     *          "nickname": "黑天使",
     *          "introduce": "个人介绍",
     *          "class_name": "长安画派",
     *          "long": 23,
     *          "width": 34,
     *          "height": 11,
     *          "shape": 1,
     *          "main_image": "www.1111.com",
     *          "title": "标题1911",
     *          "create_year": "2018",
     *          "art_introduce": "jieshao111111",
     *          "image_info": "www.111.com11111",
     *          "author": "zhangsan",
     *          "collect_num": 0,
     *          "comment_num": 0,
     *          "collect": [
     *              {
     *                  "user_id": 18,
     *                  "photo": "https://yy363626256-1258529412.cos.ap-beijing.myqcloud.com/image/t4YU3Hc2HqYAuIIxMoTgMonjMa7lHXhRzU35T0Lf.jpeg"
     *              }
     *          ],
     *          "commentContent": [
     *              {
     *                  "user_id": 18,
     *                  "reply_user_id": 0,
     *                  "content": "回复内容",
     *                  "nickname": "黑天使",
     *                  "reply_nickname": null
     *              },
     *              {
     *                  "user_id": 18,
     *                  "reply_user_id": 0,
     *                  "content": "回复内容1",
     *                  "nickname": "黑天使",
     *                  "reply_nickname": null
     *              },
     *              {
     *                  "user_id": 18,
     *                  "reply_user_id": 6,
     *                  "content": "回复内容1",
     *                  "nickname": "黑天使",
     *                  "reply_nickname": "金色雨滴"
     *              }
     *          ]
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
        $artInfo = $this->artService->getArtInfo($art->id);

        return $this->success(200, $artInfo);
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
     *     "create_year":"20191",
     *   "art_info_model":{
     *     "id":7,
     *     "author":"zhangsan",
     *     "image_info":"www.111.com11111",
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
     *          "create_year":"20191",
     *          "art_info_model": {
     *              "id": 7,
     *              "art_id": 19,
     *              "author": "zhangsan",
     *              "image_info": "www.111.com11111",
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
     * Date:2019/04/18 15:37
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
            $this->artService->deleteArt($art);
            
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(200);
     }


    /**
     * @api {GET} /api/v1/userClassify/artList 作品【分类作品列表展示】
     * @apiGroup Art
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/04/18 13:47
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {String} user_classify_id 分类id
     *
     * @apiParamExample {json} 请求参数示例：
     * {
     *   "user_classify_id":1
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
     * @apiSuccess (返回字段:) {Integer} data.id  主键id
     * @apiSuccess (返回字段:) {String} data.class_name  分类名称
     * @apiSuccess (返回字段:) {Integer} data.long  长度
     * @apiSuccess (返回字段:) {Integer} data.width  宽度
     * @apiSuccess (返回字段:) {Integer} data.height  高度
     * @apiSuccess (返回字段:) {Integer} data.shape  类型：1平面；2立体
     * @apiSuccess (返回字段:) {String} data.title  标题
     * @apiSuccess (返回字段:) {String} data.create_year  创建年份
     *
     *
     *
     * @apiSuccessExample 成功时返回的数据:
     *  HTTP/1.1 200 Success
     *  {
     *      "status": true,
     *      "code": 200,
     *      "message": "SUCCESS",
     *      "data": [
     *          {
     *              "id": 14,
     *              "class_name": "吴门画派",
     *              "long": 23,
     *              "width": 34,
     *              "height": 11,
     *              "shape": 1,
     *              "main_image": "www.1111.com",
     *              "title": "标题1",
     *              "create_year": "2018"
     *          },
     *          {
     *              "id": 15,
     *              "class_name": "吴门画派",
     *              "long": 23,
     *              "width": 34,
     *              "height": 11,
     *              "shape": 1,
     *              "main_image": "www.1111.com",
     *              "title": "标题1",
     *              "create_year": "2018"
     *          }
     *      ]
     *  }
     **/    
    /**
     * 作品
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
     public function userClassifyArtList(Request $request)
     {
          $result = $this->artService->classifyArtList($request->input('user_classify_id'));

          return $this->success(200, $result);
     }
}
