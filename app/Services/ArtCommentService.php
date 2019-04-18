<?php

namespace App\Services;


use App\Models\ArtCommentModel;
use App\Models\ArtModel;


class ArtCommentService
{
    /**
     * 创建评论
     * @param  array $createCommentRequest 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function createComment($createCommentRequest)
    {
        $createCommentRequest->merge(['user_id' => \Auth::user()->user_id]);
        $commentData = $createCommentRequest->all();

        $artComment = new ArtCommentModel($commentData);      
        $art = ArtModel::find($commentData['art_id']);

        \DB::beginTransaction();
        try {
            $artComment->save();
            $art->increment('comment_num', 1);

            \DB::commit();
        } catch (\QueryException $ex) {
            
            \DB::rollback();
            throw $ex;
        }
        
        return $artComment;  
    }


    /**
     * 获取作品评论内容
     * @param  int $artId
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getArtComment($artId)
    {
        return ArtCommentModel::whereArtId($artId)
            -> join('user_info as a', 'a.user_id', '=', 'art_comment.user_id')
            -> leftJoin('user_info as b', 'b.user_id', '=', 'art_comment.reply_user_id')
            -> select(['art_comment.user_id', 'art_comment.reply_user_id', 'art_comment.content', 'a.nickname', \DB::raw('b.nickname as reply_nickname')])
            -> orderBy('art_comment.created_at')
            -> get();    
    }
}