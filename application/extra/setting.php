<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/7
 * Time: 13:02
 */

return [
    'img_prefix' => 'http://xy.liruoning.cn:8010',
    'url_prefix' => 'http://47.102.205.111:9035',
    'background_total' => 7,
    'background_suffix' => '.jpg',
    'aphorism_total' => 30,
    'finish_flag' => 'finish',
    "pagesize" => 10,
    'redis_host' => \think\Env::get('redis.host', '127.0.0.1'), //连接redis的主机ip
    'redis_port' => \think\Env::get('redis.port', 6379),            //连接redis的端口号
    'redis_password' => \think\Env::get('redis.password', 123456),
    'redis_login_code_prefix' => 'redis_login_code_',
    'img_url' => ROOT_PATH . 'public' . DS . 'upload' . DS . 'user'
];
