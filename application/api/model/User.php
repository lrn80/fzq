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

    protected $hidden = ['img_id', 'update_time', 'password'];

    /**
     * 验证用户是否存在，并返回用户信息
     */
    public function loginCheck($data){
        $result = $this->whereOr('username', '=', $data['username'])
            ->whereOr('phone_number', '=', $data['username'])
            ->where('password', '=', $data['password'])
            ->find();
        return $result;
    }

    /**
     * 插入新用户
     */
    public function createNewUser($data){
        try{
            $result = $this->save([
                'username' => $data['username'],
                'password' => md5($data['password']),
                'phone_number' => $data['phonenumber']
            ]);
            return $result;
        }catch (PDOException $e){
            throw new RegisterException([
                'msg' => '用户名已存在'
            ]);
        }

    }
}