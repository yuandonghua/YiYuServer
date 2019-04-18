<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodThumbModel extends Model
{
    const STATUS_THUMB = 1; // 点赞
    const STATUS_THUMB_NO = 0; // 取消点赞
    /**
     * 表名
     */
    protected $table = 'mood_thumb';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'mood_id', 'user_id', 'status'
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

    public function scopeWhereStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
