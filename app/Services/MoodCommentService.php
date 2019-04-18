<?php

namespace App\Services;

use App\Models\MoodCommentModel;
use App\Models\MoodModel;


class MoodCommentService
{
    /**
     * 动态-评论添加
     * @param $createMoodCommentArray
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createMoodComment($createMoodComment)
    {
        $createMoodComment['user_id'] = \Auth::user()->user_id;

        \DB::beginTransaction();
        try {
            MoodCommentModel::create($createMoodComment);
            $this->updateMoodCommentNumber($createMoodComment['mood_id']);

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }
        
        return true;   
    }

    /**
     * 更新动态的评论数量
     * @param $moodId 动态id
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    protected function updateMoodCommentNumber($moodId)
    {
        $mood = MoodModel::find($moodId);
        $mood->comment_num = MoodCommentModel::whereMoodId($moodId)->count();
        $mood->save();
    }
    
       
    /**
     * 删除动态的评论
     * @param $moodId 动态评论
     * @return bool
     * @throws \Illuminate\Database\QueryException
     */
    public function deleteMoodComment($moodComment)
    {
        if ($moodComment->user_id != \Auth::user()->user_id) {
            return [];
        }
        
        \DB::beginTransaction();
        try {
            $moodComment->delete();
            $this->updateMoodCommentNumber($moodComment->mood_id);

            \DB::commit();
        } catch (\QueryException $ex) {

            \DB::rollback();
            throw $ex;
        }
    }
}