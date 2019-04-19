<?php

namespace App\Services;

use App\Models\ArtCollectModel;
use App\Models\ArtModel;

class ArtCollectService
{
   
    /**
     * 获取作品收藏的用户
     * @param  int $artId
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getArtCollect($artId)
    {
        return ArtCollectModel::join('user_info', 'art_collect.user_id', '=', 'user_info.user_id')
            -> where('art_collect.art_id', $artId)
            -> where('art_collect.status', ArtCollectModel::STATUS_COLLECT)
            -> orderBy('art_collect.created_at', 'desc')
            -> select(['art_collect.user_id', 'user_info.photo'])
            -> get();    
    }


    /**
     * 收藏作品
     * @param  int $artId 收藏的作品id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createArtCollect($artId)
    {       
        $art = ArtModel::find($artId);

        \DB::beginTransaction();
        try {

            $artCollect = ArtCollectModel::updateOrCreate(['art_id' => $artId, 'user_id' => \Auth::user()->user_id], ['status' => ArtCollectModel::STATUS_COLLECT]);
            $art->increment('collect_num', 1);

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }
        
        return $artCollect;
    }


    /**
     * 收藏作品-取消收藏
     * @param  int $artId 收藏的作品id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteArtCollect($artId)
    {             
        $art = ArtModel::find($artId);

        \DB::beginTransaction();
        try {
            ArtCollectModel::whereArtId($artId)->whereUserId(\Auth::user()->user_id)->update(['status' => ArtCollectModel::STATUS_COLLECT_NO]);
            $art->decrement('collect_num', 1);

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }
        
        return [];
    }

    /**
     * 收藏作品-收藏作品列表
     * @param  
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getArtCollectList()
    {
        $userId = \Auth::user()->user_id;
        $artIdArray = ArtCollectModel::whereUserId($userId)->orderBy('updated_at')->pluck('art_id')->toArray();
        return ArtModel::Join('classify', 'arts.classify_id', '=', 'classify.id')
            -> Join('art_info', 'arts.id', '=', 'art_info.art_id')
            -> whereIn('arts.id', $artIdArray)
            -> select(['arts.id', 'classify.class_name', 'arts.long', 'arts.width', 'arts.height', 'arts.shape', 'arts.main_image', 'arts.title', 'arts.create_year'])
            -> get();
    }
}