<?php
/**
 * Created by PhpStorm.
 * User: 李若宁
 * Date: 2019/11/8
 * Time: 13:44
 */
use think\Route;

/*******************news首页***************************/
//首页左边内容请求api
Route::get('api/:version/email/getcode','api/:version.email/getCode');
Route::post('api/:version/user/register','api/:version.user/register');
Route::post('api/:version/user/login','api/:version.user/login');
Route::post('api/:version/user/login','api/:version.user/login');
