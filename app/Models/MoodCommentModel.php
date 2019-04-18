<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodCommentModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'mood_comment';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'mood_id', 'user_id', 'reply_user_id', 'content'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];


    public function scopeWhereMoodId($query, $moodId)
    {
        return $query->where('mood_id', $moodId);
    }
}
