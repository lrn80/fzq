<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\api\service;
use app\api\model\User as UserModel;
use think\Log;
use app\api\model\News;
class User
{
    public static function find($params)
    {
        $user_model = new UserModel();
        $user_info = $user_model->getUserInfo($params);
        if ($user_info) {
            $user_info['token'] = (new TokenUser())->get($user_info['id']);
        }

        return $user_info;
    }

    public static function saveUserInfo($data)
    {
        $user_model = new UserModel();
        $res = $user_model->saveUser($data);
        if (!$res) {
            Log::error("User Insert Fail Email:{$data['email']}");
            return false;
        }

        return $res;
    }

    public static function getUserInfoByCondition($condition) {
        $user_model = new UserModel();
        return $user_model->getUserByCondition($condition);
    }

    public static function upVoteSum($uid)
    {
        $news_model = new News();
        $count = $news_model->where(['uid' => $uid])->sum('upvote');
        return ['sum' => $count];
    }

    public static function edit($params, $uid)
    {
        $update_data = [];
        if (empty($params)) {
            return true;
        }

        if (isset($params['username'])) {
            $update_data['username'] = $params['username'];
        }

        if (isset($params['sex'])) {
            $update_data['sex'] = $params['sex'];
        }

        if (isset($params['birth'])) {
            $update_data['birth'] = $params['birth'];
        }

        if (isset($params['avatar'])) {
            $update_data['avatar'] = $params['avatar'];
        }

        $update_data['id'] = $uid;
        return UserModel::update($update_data);
    }
}
