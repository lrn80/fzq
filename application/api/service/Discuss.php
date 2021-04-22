<?php


namespace app\api\service;

use app\api\common\CommConst;
use app\api\model\User as UserModel;
use app\api\model\News as NewsModel;
use app\api\model\UserUpvoteNews;
use app\exception\DiscuessExtistException;
use app\exception\DiscussNotUpvoteException;
use app\exception\NewException;
use app\api\model\Discuss as DiscussModel;
use think\Log;

class Discuss
{
    const UPVOTE_EXTIST = 1; //点过赞
    const UPVOTE_NOT_EXTIST = 0; //未点过赞
    public static function addDiscuss($uid, $news_id, $content)
    {
        $news_model = new NewsModel();
        $news_info = $news_model->where(['id' => $news_id])->find();
        if (!$news_info) {
            throw new NewException();
        }

        $data = [
            'uid' => $uid,
            'news_id' => $news_id,
            'content' => $content
        ];
        $discuss_model = new DiscussModel();
        $res = $discuss_model->insert($data);
        if (!$res) {
            Log::error("insert discuss fail uid:{$uid} news_id:{$news_id} content:{$content}");
            return false;
        }

        return true;
    }

    public static function discussUpvote($discuss_id, $news_id, $uid)
    {
        $discuss_model = new DiscussModel();
        $user_upvote_model = new UserUpvoteNews();
        $info = $discuss_model->where(['id' => $discuss_id, 'news_id' => $news_id])->find();
        if (!$info) {
            return false;
        }

        $user_upvote_model->startTrans();
        try {
            $data = [
                'uid' => $uid,
                'news_id' => $discuss_id,
                'type' => CommConst::UPVOTE_DISCUSS,
            ];
            $res = $user_upvote_model->insert($data);
            if (!$res) {
                Log::error(__METHOD__ . "insert upvote fail uid{$uid} news_id:{$news_id} type:" . CommConst::UPVOTE_NEWS);
                $user_upvote_model->rollback();
                return false;
            }

            $res = $discuss_model->where(['id' => $discuss_id, 'news_id' => $news_id])->setInc('upvote');
            if (!$res) {
                Log::info(__METHOD__ . "setInc fail discuss_id:{$discuss_id} news_id:{$news_id}");
                $user_upvote_model->rollback();
                return false;
            }

            $user_upvote_model->commit();
            return true;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . "discuss upvote fail msg:" . $e->getMessage());
            throw new DiscuessExtistException();
        }
    }

    public static function discussUpvoteDel($discuss_id, $news_id, $uid)
    {
        $discuss_model = new DiscussModel();
        $user_upvote_model = new UserUpvoteNews();
        $info = $discuss_model->where(['id' => $discuss_id, 'news_id' => $news_id])->find();
        if (!$info) {
            return false;
        }

        $user_upvote_model->startTrans();
        try {
            $data = [
                'uid' => $uid,
                'news_id' => $discuss_id,
                'type' => CommConst::UPVOTE_DISCUSS,
            ];
            $res = $user_upvote_model->where($data)->delete();
            if (!$res) {
                Log::error(__METHOD__ . " delete upvote fail uid{$uid} news_id:{$news_id} type:" . CommConst::UPVOTE_NEWS);
                $user_upvote_model->rollback();
                return false;
            }

            $res = $discuss_model->where(['id' => $discuss_id, 'news_id' => $news_id])->setDec('upvote');
            if (!$res) {
                Log::info(__METHOD__ . " setDec fail discuss_id:{$discuss_id} news_id:{$news_id}");
                $user_upvote_model->rollback();
                return false;
            }

            $user_upvote_model->commit();
            return true;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " discuss upvote fail msg:" . $e->getMessage());
            throw new DiscussNotUpvoteException();
        }
    }

    public static function getDiscussList($news_id, $uid)
    {
        $disscuss_model = new DiscussModel();
        $user_model = new UserModel();
        $user_upvote_model = new UserUpvoteNews();
        $list = $disscuss_model->where(['news_id' => $news_id])->order('id','desc')->select();
        $uids = array_column($list->toArray(), 'uid');
        $discuss_ids = array_column($list->toArray(), 'id');

        $upvote_data = [
            'uid' => $uid,
            'news_id' => ['in', $discuss_ids],
            'type' => CommConst::UPVOTE_DISCUSS
        ];
        $user_upvote_list = $user_upvote_model->where($upvote_data)->select()->toArray();
        $user_upvote_list = array_column($user_upvote_list, null, 'news_id');
        $user_list = $user_model->where('id', 'in', $uids)->select()->toArray();
        $user_list = array_column($user_list, null, 'id');
        $list = $list->toArray();
        foreach ($list as &$item) {
            if (isset($user_upvote_list[$item['id']])) {
                $item['upvote_status'] =  self::UPVOTE_EXTIST;
            } else {
                $item['upvote_status'] =  self::UPVOTE_NOT_EXTIST;
            }

            if (isset($user_list[$item['uid']])) {
                $item['user_info'] = $user_list[$item['uid']];
            }
            unset($item['uid'], $item['user_info']['id']);
        }

        unset($item);
        return $list;
    }
}