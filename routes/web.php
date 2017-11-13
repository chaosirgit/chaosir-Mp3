<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('user/register','UserController@register');             //注册
Route::post('user/login','UserController@login');                   //登陆
Route::post('list','ListController@add');                           //创建播放列表
Route::delete('list','ListController@del');                         //删除播放列表
Route::get('list','ListController@get_list');                       //获取播放列表
Route::post('admin/music','AdminController@add');                   //上传歌曲
