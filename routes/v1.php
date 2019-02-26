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
    //Route::get('index', 'IndexController@Index');
    Route::resource('art', 'ArtController');

});


// 需要token认证的路由
Route::group(['middleware' => ['jwt.auth']], function () {
    //Route::get('index', 'IndexController@Index');
    
    Route::post('storage/imageUpload', 'StorageController@imageUpload');
});