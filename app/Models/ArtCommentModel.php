<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtCommentModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'art_comment';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'art_id', 'user_id', 'content', 'reply_user_id'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * 作品的评论内容
     */
    public function scopeWhereArtId($query, $artId)
    {
        return $query->where('art_id', $artId);
    }
}
