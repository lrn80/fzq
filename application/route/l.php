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
Route::post('api/:version/category/delcategory','api/:version.category/userCategoryDel'); //用户频道删除
Route::post('api/:version/category/addcategory','api/:version.category/UserCategory'); //用户设置频道



Route::get('api/:version/news/getnewslist','api/:version.news/getNewsList');
Route::get('api/:version/news/getnewsinfo','api/:version.news/getNewsInfo');
Route::get('api/:version/news/upvote','api/:version.news/upvote');
Route::get('api/:version/news/delupvote','api/:version.news/delUpvote');
Route::get('api/:version/news/search','api/:version.news/search'); // 文章搜索

// 获取token
Route::get('api/:version/token/gettoken','api/:version.token/gettoken');

//搜索历史
Route::get('api/:version/search/history','api/:version.search/searchHistory');
Route::delete('api/:version/search/delete','api/:version.search/delHistory'); // 文章搜索

// 用户收藏
Route::post('api/:version/collect/collect','api/:version.collect/userCollect');
