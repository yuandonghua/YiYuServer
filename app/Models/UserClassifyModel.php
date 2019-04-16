<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClassifyModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'user_classify';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'user_id', 'class_name' 
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];
    
    public function scopeWhereUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
