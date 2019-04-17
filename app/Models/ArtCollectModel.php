<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtCollectModel extends Model
{
    const STATUS_COLLECT = 1; //收藏
    const STATUS_COLLECT_NO = 0; // 取消收藏

    /**
     * 表名
     */
    protected $table = 'art_collect';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'art_id', 'user_id', 'status'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * 用户关注的作品id
     */
    public function scopeWhereArtId($query, $artId)
    {
        return $query->where('art_id', $artId);
    }

    /**
     * 关注的作品用户id
     */
    public function scopeWhereUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

}
