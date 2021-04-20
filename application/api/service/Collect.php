<?php


namespace app\api\service;
use app\api\model\Category as CategoryModel;
use app\api\model\UserCollectNews;
use think\Log;

class Collect
{
    public static function userCollect($uid, $news_id)
    {
        $category_model = new CategoryModel();
        $category_info = $category_model->where(['uid' => $uid, 'id' => $news_id])->find();
        if (empty($category_info)) {
            return false;
        }

        $data = [
            'uid' => $uid,
            'news_id' => $category_info['id'],
            'title' => $category_info['title']
        ];

        $res = (new UserCollectNews())->insert($data);
        if (!$res) {
            Log::error(__METHOD__ . "user collect news fail uid:{$uid} cid:{$cid}");
            return false;
        }

        return true;
    }
}