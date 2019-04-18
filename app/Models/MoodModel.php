<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoodModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'mood';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'mood_content', 'image_url', 'user_id'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];
}
