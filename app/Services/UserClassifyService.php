<?php

namespace App\Services;


use App\Models\UserClassifyModel;
use App\Models\ArtModel;
use App\Models\ArtInfoModel;
use App\Models\ArtCommentModel;
use App\Models\ArtCollectModel;


class UserClassifyService
{
    /**
     * 获取用户分类列表
     * @param array $createArtDataRequest
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getUserClassifyInfoByUserId(int $userId) 
    {
        return UserClassifyModel::orderBy('updated_at')->whereUserId($userId)->get();    
    }

    
    /**
     * 创建用户分类
     * @param array $createUserClassifyData
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createUserClassify(Array $createUserClassifyData) 
    {
        $createUserClassifyData['user_id'] = \Auth::user()->user_id;
        try {
            $userClassify = new UserClassifyModel($createUserClassifyData);
            $userClassify->save();
            
        } catch (\QueryException $ex) {

            throw $ex;
        }
        
        return UserClassifyModel::find($userClassify->id); 
    }

    /**
     * 删除用户分类并删除分类下作品、作品下评论、收藏
     * @param array $createUserClassifyData
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteUserClassify($userClassifyId) 
    {
        \DB::beginTransaction();
        try {

            $userClassify = UserClassifyModel::find($userClassifyId);    
            if ($userClassify->user_id == \Auth::user()->user_id) {

                $deleteArtIdArray = ArtModel::whereUserClassify($userClassifyId)->pluck('id')->toArray();
                if ($deleteArtIdArray) {
                    ArtCollectModel::whereIn('art_id', $deleteArtIdArray)->delete();
                    ArtCommentModel::whereIn('art_id', $deleteArtIdArray)->delete();
                    ArtModel::whereUserClassify($userClassify->id)->delete();
                }                
                $userClassify->delete();
            }

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }

        return true;
    }

    /**
     * 创建用户分类
     * @param array $createUserClassifyData
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function updateUserClassify(Array $updateUserClassifyData, int $userClassifyId) 
    {
        $userClassify = UserClassifyModel::find($userClassifyId);
        isset($updateUserClassifyData['class_name']) ? $userClassify->class_name =  $updateUserClassifyData['class_name'] : '';
        isset($updateUserClassifyData['image_url']) ? $userClassify->class_name =  $updateUserClassifyData['image_url'] : '' ;     
        
        try {
            if (\Auth::user()->user_id == $userClassify->user_id) {
                $userClassify->save();
            } 
            
        } catch (\QueryException $ex) {

            throw $ex;
        }
        
        return UserClassifyModel::find($userClassify->id);    
    }
}