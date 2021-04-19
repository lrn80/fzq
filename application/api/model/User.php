<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 14:20
 */

namespace app\api\model;


use app\exception\RegisterException;
use think\exception\PDOException;

class User extends BaseModel {

    protected $hidden = ['update_time', 'password'];

    /**
     * 检查用户名密码是否正确
     */
    public function getUserInfo($data){
        return $this->where('email', '=', $data['email'])
                    ->where('password', '=', md5($data['password']))
                    ->find();
    }

    /**
     * 插入新用户
     */
    public function saveUser($data){
        try{
            return $this->insert([
                'email' => $data['email'],
                'password' => md5($data['password']),
                'avatar' => './upload/user/924e655022aee453710743990c24134c.jpg',
            ]);
        }catch (PDOException $e){
            throw new RegisterException([
                'msg' => '用户已存在'
            ]);
        }

    }

    public function getUserByCondition($condition, $field = [])
    {
        return $this->where($condition)->field($field)->find();
    }
}
