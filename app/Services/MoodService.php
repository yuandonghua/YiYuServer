<?php

namespace App\Services;


use App\Models\MoodModel;
use App\Models\MoodThumbModel;
use App\Models\MoodCommentModel;

class MoodService
{
    /**
     * 创建动态
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createMood($createMoodArray)
    {
        $createMoodArray['user_id'] = \Auth::user()->user_id;
        $mood = new MoodModel($createMoodArray);
        $mood->save();

        return $mood;    
    }

    /**
     * 删除动态
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteMood($moodId)
    {   

        $deleteMood = MoodModel::find($moodId);
        if ($deleteMood->user_id != \Auth::user()->user_id) {
            return [];
        }

        \DB::beginTransaction();
        try {
            $deleteMood->delete();
            MoodThumbModel::whereMoodId($deleteMood->id)->delete();
            MoodCommentModel::whereMoodId($deleteMood->id)->delete();

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }

        return [];    
    }

    
    /**
     * 动态-我的动态列表
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getMoodList()
    {   
        $userId = \Auth::user()->user_id;

        return MoodModel::whereUserId($userId)->orderBy('created_at')->get();
    }


    public function showMood($moodId)
    {   
        
        $mood =  MoodModel::join('user_info', 'user_info.user_id', '=', 'mood.user_id')
            ->select(['mood.*', 'user_info.user_id', 'user_info.nickname', 'user_info.photo', 'user_info.introduce'])
            ->find($moodId);
        $mood->thumbList = $mood->thumb_num ? MoodThumbModel::whereMoodId($moodId)
            -> join('user_info', 'user_info.user_id', '=', 'mood_thumb.user_id')
            -> select(['mood_thumb.*', 'user_info.photo'])
            -> orderBy('created_at', 'desc')
            -> get() : [];
        $mood->commentList =  $mood->comment_num ? MoodCommentModel::whereMoodId($moodId)
            -> join('user_info as a', 'a.user_id', '=', 'mood_comment.user_id')
            -> leftjoin('user_info as b', 'b.user_id', '=', 'mood_comment.reply_user_id')

            -> select(['mood_comment.*', \DB::raw('b.nickname as reply_nickname'), 'a.nickname'])
            -> orderBy('mood_comment.created_at')
            ->get() : [];

        return $mood;
    }

}