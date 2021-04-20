<?php
/**
 * Created by PhpStorm.
 * User: 李若宁
 * Date: 2019/11/8
 * Time: 13:44
 */
use think\Route;

//首页左边内容请求api
Route::any('api/:version/email/anycode','api/:version.email/anyCode');
Route::any('api/:version/user/register','api/:version.user/register');
Route::any('api/:version/user/login','api/:version.user/login');
Route::any('api/:version/user/upvotesum','api/:version.user/upVoteSum'); //获赞数

// 获取分类列表
Route::any('api/:version/category/anycategorylist','api/:version.category/anyCategoryList');
Route::any('api/:version/category/delcategory','api/:version.category/userCategoryDel'); //用户频道删除
Route::any('api/:version/category/addcategory','api/:version.category/UserCategory'); //用户设置频道



Route::any('api/:version/news/anynewslist','api/:version.news/anyNewsList');
Route::any('api/:version/news/anynewsinfo','api/:version.news/anyNewsInfo');
Route::any('api/:version/news/upvote','api/:version.news/upvote');
Route::any('api/:version/news/delupvote','api/:version.news/delUpvote');
Route::any('api/:version/news/search','api/:version.news/search'); // 文章搜索

// 获取token
Route::any('api/:version/token/anytoken','api/:version.token/anytoken');

//搜索历史
Route::any('api/:version/search/history','api/:version.search/searchHistory');
Route::any('api/:version/search/delete','api/:version.search/delHistory'); // 文章搜索

// 用户收藏
Route::any('api/:version/collect/collect','api/:version.collect/userCollect');
Route::any('api/:version/collect/del','api/:version.collect/userCollectDel');
Route::any('api/:version/collect/collectlist','api/:version.collect/collectList');

// 用户评论
Route::any('api/:version/discuss/add','api/:version.discuss/discuss'); //添加评论
Route::any('api/:version/discuss/upvote','api/:version.discuss/discussUpvote'); //添加评论
Route::any('api/:version/discuss/upvotedel','api/:version.discuss/discussUpvoteDel'); //添加评论

// 关注 粉丝
Route::any('api/:version/relation/follow','api/:version.relation/follow'); //关注
Route::any('api/:version/relation/followlist','api/:version.relation/followList'); //关注列表
Route::any('api/:version/relation/fanslist','api/:version.relation/fansList'); //获取粉丝列表
