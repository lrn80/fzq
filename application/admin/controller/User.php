<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:52
 */

namespace app\admin\controller;


use app\admin\service\FileUploadService;
use app\admin\validate\CreateOrUpdateUserCheck;
use app\exception\SucceedMessage;
use app\exception\UserException;
use think\Controller;
use app\admin\model\User as UserModel;

class User extends Base
{

    public function index(){
        $users = UserModel::all();
        return $this->fetch('',[
            'users' => $users,
        ]);
    }

    public function add(){
        return $this->fetch();
    }

    public function create(){
        (new CreateOrUpdateUserCheck())->goCheck();
        $model = new UserModel();
        $data = $this->request->post();
        $result = $model->createNewUser($data);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new UserException();
        }
    }

    public function edit($id){
        $user = UserModel::get($id);
        return $this->fetch("", [
            'id' => $id,
            'user' => $user
        ]);
    }

    public function update($id){
        (new CreateOrUpdateUserCheck())->goCheck();
        $model = new UserModel();
        $data = $this->request->post();
        $result = $model->UpdateUser($id, $data);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new UserException();
        }
    }

    public function delete($id){
        $result = UserModel::deleteAndImage($id);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new UserException([
                'msg' => '删除失败'
            ]);
        }
    }
}