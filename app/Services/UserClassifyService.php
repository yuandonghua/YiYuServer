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


}