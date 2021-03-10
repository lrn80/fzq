<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 13:44
 */

\think\Route::get('/api/:ver/Advertising/:id', 'api/:ver.Advertising/getListAdvertising');
\think\Route::post('/api/:ver/arti', 'api/:ver.Arti/getSearchArticle');
