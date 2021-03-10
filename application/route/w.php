<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 13:44
 */
use think\Route;
//Route::get('/category/edit/:id', 'admin/Category/categoryEdit');
//Route::get('/category/index', 'admin/Articles/classify');

//\think\Route::get('/category/edit/:id', 'admin/Category/categoryEdit');
//\think\Route::get('/category/index', 'admin/Articles/classify');



//前端登录
Route::post('/login', 'api/v1.User/login');
Route::post('/register', 'api/v1.User/register');
Route::get('/logout', 'api/v1.User/logout');
Route::get('/userinfo', 'api/v1.User/getUserInfo');

Route::get('/links/left', 'api/v1.Link/getLinkLeft');
Route::get('/links/right', 'api/v1.Link/getLinkRight');
Route::get('/links/all', 'api/v1.Link/getLinks');
