<?php

namespace App\Services;

use App\Models\UserFollowModel;
use App\Models\UserInfoModel;

class UserFollowService
{
    /**
     * 关注列表or粉丝列表
     * @param string $follow 关键字区分关注or粉丝
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getUserFollowList($follow)
    {
        
        $userList = UserFollowModel::orderBy('user_follow.created_at');
        if ($follow == 'follow') {
            $userList = $userList->join('user_info', 'user_info.user_id', '=', 'user_follow.user_id')->where('user_follow.user_id', \Auth::user()->user_id);
        } else {
            $userList = $userList->join('user_info', 'user_info.user_id', '=', 'user_follow.follow_user_id')->where('user_follow.follow_user_id', \Auth::user()->user_id);
        }

        $userList = $userList->select(['user_info.user_id', 'user_info.photo', 'user_info.nickname'])->get();

        return $userList;
    }


    /**
     * 关注用户
     * @param  array $createFollowRequest
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createUserFollow($userId)
    {
        $selfUserId = \Auth::user()->user_id;
        $userInfo = UserInfoModel::whereUserId($userId)->first();
        $selfUserInfo = UserInfoModel::whereUserId($selfUserId)->first();
        \DB::beginTransaction();
        try {

            $userFollow = UserFollowModel::updateOrCreate(['follow_user_id' => $userId, 'user_id' => $selfUserId], ['status' => UserFollowModel::STATUS_FOLLOW]);
            $userInfo->increment('fans', 1);
            $selfUserInfo->increment('star', 1);

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }
        
        return $userFollow;   
    }


     /**
     * 取消关注
     * @param  int $artId
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteUserFollow($userId)
    {
        $selfUserId = \Auth::user()->user_id;
        
        $selfUserInfo = UserInfoModel::whereUserId($selfUserId)->first();
        $userInfo = UserInfoModel::whereUserId($userId)->first();

        \DB::beginTransaction();
        try {
            $userFollow = UserFollowModel::whereFollowUserId($userId)->whereUserId($selfUserInfo)->update(['status' => UserFollowModel::STATUS_FOLLOW_NO]);
            $selfUserInfo->decrement('star', 1);
            $userInfo->decrement('fans', 1);

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }
        
        return [];     
    }
}