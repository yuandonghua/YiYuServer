<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtModel extends Model
{
    // 表名
    protected $table = 'arts';
    // 可批量添加的字段
    protected $fillable = [
        'title', 'pulisher_user_id', 'classify_id', 'user_classify_id', 'width', 'height', 'long', 'review', 'shape', 'main_image'
    ];
}
