<?php

namespace App\Services;


use App\Models\BannerModel;


class BannerService
{
    /**
     * 轮播图列表
     * @param 
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    public function getBannerList()
    {
        return BannerModel::WhereStatusUsed()->orderBy('order_num')->get();    
    }

}