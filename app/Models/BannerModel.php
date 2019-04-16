<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    const OPEN = 1;  // 开启
    const CLOSE = 0; // 关闭 
    /**
     * 表名
     */
    protected $table = 'banner';

    /**
     * 可批量添加的字段
     */
    // protected $fillable = [
        
    // ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];
    
    public function scopeWhereStatusUsed($query)
    {
        return $query->where('status', self::OPEN);
    }
}