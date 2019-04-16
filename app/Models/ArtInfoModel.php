<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtInfoModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'art_info';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'art_id', 'author', 'image_info', 'create_year', 'introduce'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

}
