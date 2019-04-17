<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollowModel extends Model
{

    const STATUS_FOLLOW = 1;  // 关注
    const STATUS_FOLLOW_NO = 0; // 取消关注
    /**
     * 表名
     */
    protected $table = 'user_follow';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'user_id', 'follow_user_id', 'status'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * 关注列表
     */
    public function scopeWhereFollowUserId($query, $userId)
    {
        return $query->where('follow_user_id', $userId);
    }

    /**
     * 粉丝列表
     */
    public function scopeWhereUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
