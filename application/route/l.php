<?php
/**
 * Created by PhpStorm.
 * User: 李若宁
 * Date: 2019/11/8
 * Time: 13:44
 */
use think\Route;

//首页左边内容请求api
Route::get('api/:version/email/getcode','api/:version.email/getCode');
Route::post('api/:version/user/register','api/:version.user/register');
Route::post('api/:version/user/login','api/:version.user/login');

// 获取分类列表
Route::get('api/:version/category/getcategorylist','api/:version.category/getCategoryList');


Route::get('api/:version/news/getnewslist','api/:version.News/getNewsList');
Route::get('api/:version/news/getnewsinfo','api/:version.news/getNewsInfo');
Route::get('api/:version/news/upvote','api/:version.news/upvote');
Route::get('api/:version/news/delupvote','api/:version.news/delUpvote');
Route::get('api/:version/news/search','api/:version.news/search'); // 文章搜索


Route::get('api/:version/token/gettoken','api/:version.token/gettoken');
