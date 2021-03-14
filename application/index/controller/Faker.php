<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/12
 * Time: 21:02
 */

namespace app\index\controller;


use Faker\Factory;
use think\Db;

class Faker{
    public function makeFaker(){
        $faker = Factory::create('zh_CN');
        $data = [];
        for ($i=0; $i<50; $i++){
            $data[] = [
                'title' => $faker->realText(50),
                'cid' => rand(1,7),
                'author' => $faker->name,
                'image_url' => "123",
                'content' => $faker->text(1000),
                'upvote' => rand(0,10000),
                'create_time' => $faker->date("Y-m-d H:i:s"),
            ];
        }
        var_dump($data);
        Db::table('news')->insertAll($data);
    }
}