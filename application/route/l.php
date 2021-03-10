<?php
/**
 * Created by PhpStorm.
 * User: 李若宁
 * Date: 2019/11/8
 * Time: 13:44
 */
use think\Route;
/*******************************************************************/
/*
 * Articles 相关的api
 *
 * */
/*******************news首页***************************/
//首页左边内容请求api
Route::get('api/:version/article/leftindex','api/:version.Article/leftIndex');
//首页右边内容
Route::get('api/:version/article/rightindex','api/:version.Article/rightIndex');
//首页分类内容精准查询
Route::get('api/:version/article/catearticle/:cid/:limit','api/:version.Article/cateArticle');
/*******************list列表页***************************/
//得到侧边栏的值
Route::get('api/:version/article/cate','api/:version.Article/getCateId');
//得到新闻的列表页 含有子分类的传输字符串 传输相应的id
Route::get('api/:version/article/newslist/:cateid/:page','api/:version.Article/newsListInt');
//最热新闻
Route::get('api/:version/article/hotnews/:page','api/:version.Article/theHotNews');
/*****************图文落地页****************************/
//图文左边的文章内容的id
Route::get('api/:version/article/imagetext/:articleId','api/:version.Article/imageText');
//热门文章
Route::get('api/:version/article/pushhotnews/:page','api/:version.Article/pushHotNews');
/*****************推荐页***************************/
Route::get('api/:version/article/pushleftindex','api/:version.Article/pushLeftIndex');
Route::get('api/:version/article/tuijian','api/:version.Article/tuiJian');

