<?php
namespace app\admin\model;

use app\exception\UserException;
use think\Model;

class Admin extends Model {
    protected $table = "admin_user";

    protected $hidden = ['password'];

    public function createNewAdmin($data){
        try {
            $result = self::create([
                'username'     => $data['username'],
                'password'   => md5($data['password']),
            ]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e){
            throw new UserException([
                'msg' => '管理员已存在'
            ]);
        }
    }

    public function updateAdmin($id, $data){
        $update_data = [
            'id' => $id,
            'username'     => $data['username'],
        ];

        if (!empty($data['password'])){
            $password = md5($data['password']);
            $update_data['password'] = $password;
        }
//        try{
        $result = self::update($update_data);
        if ($result){
            return true;
        }else{
            return false;
        }
//        }catch (\Exception $e){
//            throw new ArticleException([
//                'msg' => '文章添加异常'
//            ]);
//        }
    }
}