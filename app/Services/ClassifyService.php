<?php

namespace App\Services;


use App\Models\ClassifyModel;


class ClassifyService
{
    /**
     * 获取分类列表
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getClassifyList($pid)
    {
        return ClassifyModel::WherePid($pid)->orderBy('order_num')->get();    
    }

}