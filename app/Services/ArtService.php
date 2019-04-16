<?php

namespace App\Services;

use App\Models\ArtModel;
use App\Models\ArtInfoModel;


class ArtService
{
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

    public function getArtList($searchWhere)
    {
        $artList = ArtModel::leftJoin('user_info', 'arts.pulisher_user_id', '=', 'user_info.user_id')
            -> leftJoin('classify', 'arts.classify_id', '=', 'classify.id')
            -> select(['arts.id', 'user_info.photo', 'user_info.nickname', 'user_info.introduce', 'classify.class_name', 'arts.long', 'arts.width', 'arts.height', 'arts.shape', 'arts.main_image', 'arts.title', 'arts.create_year', 'arts.thumb_num', 'arts.comment_num'])
            -> orderBy('arts.order_num', 'desc');

        if (is_numeric($searchWhere)) {
            $artList = $artList->where('classify.pid', $searchWhere);
        } else if($searchWhere = 'recommend') {
            $artList = $artList->where('arts.recommend', ArtModel::RECOMMEND);
        } else if($searchWhere = 'follow') {
            $artId = [];

            $artList = $artList->whereIn('arts.id', $artId);
        }
        

        $artList = $artList->get();
            
        return $artList;
    }
}