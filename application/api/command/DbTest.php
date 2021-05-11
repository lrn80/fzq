<?php
/**
 * User: ruoning
 * Date: 2021/5/11
 * motto: 知行合一!
 */


namespace app\api\command;


use app\api\model\News;
use think\console\Command;
use think\console\Input;
use think\console\Output;

/**
 * 造数据库假数据
 * Class DbTest
 * @package app\api\command
 */
class DbTest extends Command
{
    protected function configure()
    {
        $this->setName('db_test')->setDescription('db  ');
    }

    protected function execute(Input $input, Output $output)
    {
        $newsModel = new News();
        $page = 1;
        $limit = 10;
        $total = 0;
        while (true){
            $newsList = $newsModel->page($page)->limit($limit)->select()->toArray();
            $ids = array_column($newsList, 'id');
            $effect = 0;
            foreach ($ids as $id){
                $data = [
                    'id' => $id,
                    'image_url' => '/upload/user/'. random_int(1, 10) . '.jpg',
                ];
                $effect = $effect + $newsModel->save($data, ['id' => $id]);
            }

            $output->writeln("page:{$page} effect:$effect count:" . count($newsList));
            $page++;
            $total = $total + $effect;
            if (empty($newsList)){
                break;
            }
        }

        $output->writeln("done:$total");
    }
}