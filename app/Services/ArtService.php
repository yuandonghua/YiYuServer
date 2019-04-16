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

}