<?php

namespace App\Services;


use App\Models\UserModel;
use App\Models\LoginModel;
use App\Models\UserInfoModel;


class UserService
{
    /**
     * 创建用户
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createUser($credentials)
    {
        if (LoginModel::TYPE_WECHAT == $credentials['type']) {
            $user['wechat'] = $credentials['account'];
        }
        if (LoginModel::TYPE_QQ == $credentials['type']) {
            $user['qq'] = $credentials['account'];
        }
        $userInfo['sex'] = $credentials['sex'];
        $userInfo['nickname'] = $credentials['nickname'];
        $userInfo['photo'] = $credentials['photo'];
        $userInfo['created_at'] = date('Y-m-d H:i:s', time());
        $userInfo['updated_at'] = date('Y-m-d H:i:s', time());
        \DB::beginTransaction();
        try {
            $user['created_at'] = date('Y-m-d H:i:s', time());
            $user['updated_at'] = date('Y-m-d H:i:s', time());
            $userId = UserModel::insertGetId($user);
            
            $userInfo['user_id'] = $userId;
            UserInfoModel::insert($userInfo);

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }

        return $userId;
    }


    /**
     * 获取用户信息
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getUserInfo($userId)
    {
        return UserInfoModel::whereUserId($userId)->first()->toArray();
    }

    /**
     * 更新用户信息
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function updateUserInfo($updateUserInfoData)
    {
        $userInfo = UserInfoModel::whereUserId(\Auth::user()->user_id)->first();
        
        $userInfo->fill($updateUserInfoData);
        $userInfo->save();
    }
}