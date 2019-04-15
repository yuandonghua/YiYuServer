<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\ArtService;
use App\Http\Requests\StoreArtRequest;



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
     * @api {POST} /art 作品【创建】
     * @apiGroup Auth
     * @apiversion 0.1.0
     * @apiDescription
     * --------------------------------------
     * Author:zhangjinyu
     *
     * Date:2019/01/31 19:09
     *
     * Email:363626256@qq.com
     * --------------------------------------
     *
     * @apiParam (请求参数:) {String} title 标题
     * @apiParam (请求参数:) {Integer} publisher_user_id 发布人
     * @apiParam (请求参数:) {Integer} style_classify_id   风格分类id
     * @apiParam (请求参数:) {Integer} user_classify_id   个人作品集分类id
     * @apiParam (请求参数:) {Integer} width   宽
     * @apiParam (请求参数:) {Integer} height   高
     * @apiParam (请求参数:) {Integer} long  长
     * @apiParam (请求参数:) {Integer} shape   1:平面;2:立体
     * @apiParam (请求参数:) {String} main_image   主图地址
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
     *     "code": 200,
     *      "message": {
     *          "info": "Success"
     *      },
     *      "data": {
     *         "list": [
     *          {
     *            "id": 2,
     *            "name": "CES",
     *            "created_at": "2018-07-09 11:46:20",
     *            "updated_at": "2018-07-10 14:40:32"
     *          }
     *        ],
     *         "count": 1
     *       }
     *  }
     **/
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtRequest $request)
    {
        
        try {
            $result = $this->artService->create($request->all());
        } catch (\QueryException $exc) {
               
            return $this->fail();
        }
        
        return $this->success(201, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        dd('art.show');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        dd('art.update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        dd('art.destroy');
    }
}
