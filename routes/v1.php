<?php

/**
 * V1版本路由
 * 这个文件里所有路由的前缀为'v1', 应用的中间件为[api, auth.jwt],
 * 控制器的命名空间前缀是'App\Http\Controllers\V1'
 * 具体细节看\App\Providers\RouteServiceProvider里的mapV1RoutesRoutes方法
 * 文件中会使用到资源路由，关于资源路由请百度《laravel与资源路由》
 */
// *重要* 写路由前请先阅读上面的路由说明
// 文件中根据后台的主要大块功能将路由分成了几个大组，
// 新加路由时请把路由加到对应的组中，不要在第一个组中堆砌路由



// 不需要token认证的路由
Route::group([], function () {
    // 作品-资源路由
    Route::resource('art', 'ArtController');

    // 作品-分类列表
    Route::get('classify/list', 'ClassifyController@classifyList');

    // 首页-轮播图
    Route::get('banner/list', 'BannerController@bannerList');

    // 作品-展示列表
    Route::get('artList', 'ArtController@artList');

    // 作品-个人分类下作品列表
    Route::get('userClassify/artList', 'ArtController@userClassifyArtList');

    // 动态-点赞列表
    Route::get('moodThumb/list', 'MoodThumbController@moodThumbList');

    
});


// 需要token认证的路由
Route::group(['middleware' => ['jwt.auth']], function () {  
    // 上传
    Route::post('storage/imageUpload', 'StorageController@imageUpload');

    // 个人分类
    Route::resource('userClassify', 'UserClassifyController');

    // 收藏作品
    Route::post('artInfo/artCollect', 'ArtCollectController@artCollect');

    // 取消收藏作品
    Route::post('artInfo/deleteArtCollect', 'ArtCollectController@deleteArtCollect');

    // 评论作品
    Route::post('artInfo/artComment', 'ArtCommentController@artComment');

    // 关注列表or粉丝列表
    Route::get('follow/follow', 'UserFollowController@followList');

    // 关注用户
    Route::post('follow/createFollow', 'UserFollowController@createFollow');


    // 取消关注用户
    Route::post('follow/deleteFollow', 'UserFollowController@deleteFollow');
    
    // 用户信息修改
    Route::put('user/userInfo', 'UserController@updateUserInfo');

    // 动态-资源路由
    Route::resource('mood', 'MoodController');

    // 动态-点赞资源路由
    Route::resource('moodThumb', 'MoodThumbController');

    // 动态-评论资源路由
    Route::resource('moodComment', 'MoodCommentController');

    // 动态-我的动态列表
    Route::get('moodList', 'MoodController@moodList');


    // 动态-我的收藏-作品列表
    Route::get('artInfo/artCollectList', 'ArtCollectController@artCollectList');
});