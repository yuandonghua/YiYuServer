<?php

namespace App\Services;


use App\Models\MoodThumbModel;
use App\Models\MoodModel;


class MoodThumbService
{
    /**
     * 动态点赞-添加
     * @param  $createMoodThumb
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createMoodThumb($createMoodThumb)
    {
        $createMoodThumb['user_id'] = \Auth::user()->user_id;

        \DB::beginTransaction();
        try {
            MoodThumbModel::updateOrCreate($createMoodThumb, ['status' => MoodThumbModel::STATUS_THUMB]);
            $this->updateMoodThumbNumber($createMoodThumb['mood_id']);

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }
        
        return true;
    }

    /**
     * 更新动态的点赞数量
     * @param $moodId 动态id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    protected function updateMoodThumbNumber($moodId)
    {
        $mood = MoodModel::find($moodId);
        $mood->thumb_num = MoodThumbModel::whereMoodId($moodId)->whereStatus(MoodThumbModel::STATUS_THUMB)->count();
        $mood->save();
    }



    /**
     * 取消点赞
     * @param $moodId 动态id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    
    public function deleteMoodThumb($moodId)
    {

        $deleteMoodThumb['mood_id'] = $moodId;
        $deleteMoodThumb['user_id'] = \Auth::user()->user_id;

        \DB::beginTransaction();
        try {
            
            MoodThumbModel::updateOrCreate($deleteMoodThumb, ['status' => MoodThumbModel::STATUS_THUMB_NO]);
            
            $this->updateMoodThumbNumber($moodId);

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }
        
        return true;
    }

    /**
     * 点赞列表
     * @param $moodId 动态id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    
    public function getMoodThumbList($moodId)
    {

        return MoodThumbModel::join('user_info', 'user_info.user_id', '=', 'mood_thumb.user_id')
            -> whereMoodId($moodId)
            -> select(['user_info.user_id', 'user_info.nickname', 'user_info.photo', 'mood_thumb.mood_id'])
            -> get();
    }
}