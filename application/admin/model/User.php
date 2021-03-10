<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 19:45
 */

namespace app\admin\model;


use app\admin\service\DeleteFileService;
use app\admin\service\FileUploadService;
use app\exception\UserException;
use think\Model;

class User extends Model {
    public function createNewUser($data){
        $image_url = FileUploadService::imgUpload('user');
        try {
            $result = self::create([
                'username'     => $data['username'],
                'password'   => md5($data['password']),
                'img_url' => $image_url,
                'phone_number'   => $data['mobile'],
            ]);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }catch (\Exception $e){
            throw new UserException([
                'msg' => '用户名重复或者手机号已注册'
            ]);
        }
    }

    public function updateUser($id, $data){
        $update_data = [
            'id' => $id,
            'username'     => $data['username'],
            'phone_number'   => $data['mobile'],
        ];
        if (!empty($data['uploadfile'])){
            $user = self::get($id);
            DeleteFileService::deleteImage($user['img_url']);
            $image_url = FileUploadService::imgUpload('user');
            $update_data['img_url'] = $image_url;
        }

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
//            throw new UserException([
//                'msg' => '用户修改异常，请重试'
//            ]);
//        }
    }

    public static function deleteAndImage($id){
        $data = self::get($id)->toArray();
        DeleteFileService::deleteImage($data['img_url']);
        $result = self::where('id','=',$id)
            ->delete();
        if ($result){
            return true;
        }else{
            return false;
        }
    }
}