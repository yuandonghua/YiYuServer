<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfoModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'user_info';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'nickname', 'photo', 'fans', 'star', 'sex', 'introduce'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

}
