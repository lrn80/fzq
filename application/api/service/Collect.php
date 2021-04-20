<?php


namespace app\api\service;
use app\api\model\Category as CategoryModel;
use app\api\model\UserCollectNews;
use think\Log;
use app\api\model\News;
class Collect
{
    public static function userCollect($uid, $news_id)
    {
        $category_model = new CategoryModel();
        $category_info = $category_model->where(['id' => $news_id])->find();
        if (empty($category_info)) {
            return false;
        }

        $data = [
            'uid' => $uid,
            'news_id' => $category_info['id'],
            'title' => $category_info['cname']
        ];

        $res = (new UserCollectNews())->insert($data);
        if (!$res) {
            Log::error(__METHOD__ . "user collect news fail uid:{$uid} news_id:{$news_id}");
            return false;
        }

        return true;
    }

    public static function delCollect($uid, $news_id)
    {
        $data = [
            'uid' => $uid,
            'news_id' => $news_id
        ];
        $res = (new UserCollectNews())->where($data)->delete();
        if (!$res) {
            Log::error(__METHOD__ . "del collect news fail uid:{$uid} news_id:{$news_id}");
            return false;
        }

        return true;
    }

    public static function collectList($uid)
    {
        $collect_model = new UserCollectNews();
        $news_model = new News();
        $collect_list = $collect_model->where(['uid' => $uid])->select()->toArray();
        $news_ids = array_column($collect_list, 'news_id');
        $news_list = $news_model->where('id', 'in', $news_ids)->select();
        $collect_list_count = $collect_model->where('news_id', 'in', $news_ids)->group('news_id')->count();
        var_dump($collect_list_count);
        exit();
    }
}
