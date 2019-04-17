<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassifyModel extends Model
{
    /**
     * 表名
     */
    protected $table = 'classify';

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
    
    public function scopeWherePid($query, $pid = 0)
    {
        return $query->where('pid', $pid);
    }

}
