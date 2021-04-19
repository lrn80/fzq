<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\api\service;
use app\api\model\User as UserModel;
use think\Log;

class User
{
    public static function find($params)
    {
        $user_model = new UserModel();
        return $user_model->getUserInfo($params);
    }

    public static function saveUserInfo($data)
    {
        $user_model = new UserModel();
        $res = $user_model->saveUser($data);
        if (!$res) {
            Log::error("User Insert Fail Email:{$data['email']}");
        }
    }

    public static function getUserInfoByCondition($condition) {
        $user_model = new UserModel();
        return $user_model->getUserByCondition($condition);
    }
}
