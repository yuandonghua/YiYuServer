<?php

namespace App\Services;

use App\Models\ArtModel;
use App\Models\ArtInfoModel;
use App\Models\ArtFollowModel;

use App\Services\ArtCommentService;
use App\Services\ArtCollectService;

class ArtService
{
    public function __construct(ArtCommentService $artCommentService, ArtCollectService $artCollectService)
    {
        $this->artCommentService = $artCommentService;
        $this->artCollectService = $artCollectService;
    }
    /**
     * 创建作品
     * @param array $createArtDataRequest
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createArt(array $createArtDataRequest) : ArtModel
    {

        \DB::beginTransaction();
        try {
            $artModel = new ArtModel();
            $artModel->fill($createArtDataRequest);
            $artModel->save();
            $artModel->artInfoModel()->create($createArtDataRequest['art_info_model']);
            $artModel->artInfoModel;
            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }

        return $artModel;
    }


    /**
     * 更新作品
     * @param array $createArtDataRequest
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function updateArt(array $updateArtDataRequest) : ArtModel
    {
        
        \DB::beginTransaction();
        try {
            
            $artModel = ArtModel::find($updateArtDataRequest['id']);
            $artInfoModel = ArtInfoModel::find($updateArtDataRequest['art_info_model']['id']);
            
            $artModel->fill($updateArtDataRequest);            
            $artInfoModel->fill($updateArtDataRequest['art_info_model']);            
          
            $artModel->save();
            $artInfoModel->save();
            
            $artModel->artInfoModel;

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }

        return $artModel;
    }


    /**
     * 首页作品列表展示
     * @param int/string $searchWhere
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getArtList($searchWhere)
    {
        $artList = ArtModel::leftJoin('user_info', 'arts.pulisher_user_id', '=', 'user_info.user_id')
            -> leftJoin('classify', 'arts.classify_id', '=', 'classify.id')
            -> select(['arts.id', 'user_info.photo', 'user_info.nickname', 'user_info.introduce', 'classify.class_name', 'arts.long', 'arts.width', 'arts.height', 'arts.shape', 'arts.main_image', 'arts.title', 'arts.create_year', 'arts.collect_num', 'arts.comment_num'])
            -> orderBy('arts.order_num', 'desc');

        // 如果是int型，表示分类id
        if (is_numeric($searchWhere)) {
            $artList = $artList->where('classify.pid', $searchWhere);

        // 如果是recommend显示推荐作品列表
        } else if($searchWhere == 'recommend') {
            $artList = $artList->where('arts.recommend', ArtModel::RECOMMEND);

        // 如果是follow显示关注列表
        } else if($searchWhere == 'follow' && \Auth::user()->id) {
            $userId = \Auth::user()->id;
            //用户关注列表
            $artIdArray = ArtFollowModel::whereUserId($userId)->pluck('art_id')->toArray(); // 
            
            $artList = $artList->whereIn('arts.id', $artIdArray);
        }
        

        $artList = $artList->get();
            
        return $artList;
    }

    /**
     * 作品详情
     * @param int/string $searchWhere
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getArtInfo($artId)
    {
        $artInfo = ArtModel::Join('user_info', 'arts.pulisher_user_id', '=', 'user_info.user_id')
            -> Join('classify', 'arts.classify_id', '=', 'classify.id')
            -> Join('art_info', 'arts.id', '=', 'art_info.art_id')
            -> select(['arts.id', 'user_info.photo', 'user_info.nickname', 'user_info.introduce', 'classify.class_name', 'arts.long', 'arts.width', 'arts.height', 'arts.shape', 'arts.main_image', 'arts.title', 'arts.create_year', \DB::raw('art_info.introduce as art_introduce'), 'art_info.image_info', 'art_info.author', 'arts.collect_num', 'arts.comment_num'])
            -> find($artId);

        $artInfo->collect = $this->artCollectService->getArtCollect($artId);
        $artInfo->commentContent = $this->artCommentService->getArtComment($artId);
           
        return $artInfo;
    }
}