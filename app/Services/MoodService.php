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

    
}