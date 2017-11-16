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

Route::get('/','IndexController@index');                            //主页
Route::post('user/register','UserController@register');             //注册
Route::post('user/login','UserController@login');                   //登陆
Route::post('list','ListController@add');                           //创建播放列表
Route::delete('list','ListController@del');                         //删除播放列表
Route::get('list','ListController@get_list');                       //获取播放列表
Route::post('admin/music','AdminController@add');                   //上传歌曲
Route::post('list/music','ListController@music');                   //添加歌曲到播放列表
Route::get('get/list/{id}','ListController@get_list_music');        //获取播放列表里的歌曲
Route::get('get/music','MusicController@get_all_music');            //获得所有歌曲
Route::get('register',function (){return view('register');}); //注册页面
Route::get('login',function(){return view('login');});        //登陆页面
Route::get('search/music','MusicController@search');                //搜索歌曲或歌手
Route::get('admin/upload','AdminController@upload');                //上传歌曲页面
