<?php

namespace App\Services;


use App\Models\UserClassifyModel;


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
        $createUserClassifyData['user_id'] = \Auth::user()->id;
        try {
            $userClassify = new UserClassifyModel($createUserClassifyData);
            $userClassify->save();
        } catch (\QueryException $ex) {

            throw $ex;
        }
        
        return $userClassify; 
    }

    /**
     * 删除用户分类
     * @param array $createUserClassifyData
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteUserClassify($userClassifyId) 
    {
        
        return UserClassifyModel::orderBy('updated_at')->whereUserId($userId)->get();    
    }

    /**
     * 创建用户分类
     * @param array $createUserClassifyData
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function updateUserClassify(Array $updateUserClassifyData) 
    {
        
        return UserClassifyModel::orderBy('updated_at')->whereUserId($userId)->get();    
    }
}