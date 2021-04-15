<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\api\service;
use app\api\model\News as NewsModel;
use app\api\model\User;
class News
{
    public static function getNewsList($params)
    {
        $news_list = [];
        $page = $params['page'];
        $news_model = new NewsModel();
        if (isset($params['cid'])) {
            $news_list = $news_model->getNewsList(['cid' => $params['cid']], $page);
        } else {
            $news_list = $news_model->getNewsList([], $page);
        }

        return $news_list;
    }

    public static function getNewsInfo($params)
    {
        $news_id = $params['news_id'];
        $news_model = new NewsModel();
        //$user_model = new User();
        //$user_info = $user_model->getUserByCondition(['uid' => $news_info['uid']], ['name', 'id']);
        return $news_model->getNewsInfo(['id' => $news_id]);
    }

    public static function upvote($uid)
    {
        $news_model = new NewsModel();
        $news_info = $news_model->getNewsInfo(['id' => $uid]);
        if (empty($news_info)) {
            return [];
        }

        $succ = $news_model->upvote(['id' => $uid]);
        if ($succ) {
            return ['upvote' => $news_info['upvote']];
        }

        return false;
    }

    public static function delUpvote($uid)
    {
        $news_model = new NewsModel();
        $news_info = $news_model->getNewsInfo(['id' => $uid]);
        if (empty($news_info)) {
            return [];
        }

        $succ = $news_model->delUpvote(['id' => $uid]);
        if ($succ) {
            return ['upvote' => $news_info['upvote']];
        }

        return false;
    }
}