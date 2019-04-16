<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtModel extends Model
{
    const RECOMMEND = 1;  // 推荐
    const RECOMMEND_NO = 0; // 不推荐
    /**
     * 表名
     */
    protected $table = 'arts';

    /**
     * 可批量添加的字段
     */
    protected $fillable = [
        'title', 'pulisher_user_id', 'classify_id', 'user_classify_id', 'width', 'height', 'long', 'review', 'shape', 'main_image'
    ];

    /**
     * 隐藏的字段
     */
    protected $hidden = [
        'updated_at', 'created_at'
    ];

    /**
     * 一对一关联ArtInfoModel模型
     */
    public function artInfoModel()
    {
        return $this->hasOne('App\Models\ArtInfoModel', 'art_id', 'id');
    }
}
