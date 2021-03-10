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
                'cate_id' => rand(1,26),
                'abstract' => $faker->realText(150),
                'author' => $faker->name,
                'pv' => rand(0,9999),
                'image_url' => "123",
                'content' => $faker->text(1000),
                'recommend' => rand(0,2),
                'create_time' => $faker->date("Y-m-d H:i:s"),
            ];
        }
        var_dump($data);
        Db::table('article')->insertAll($data);
    }
}