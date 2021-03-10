<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:27
 */

namespace app\admin\controller;


use app\admin\validate\CreateOrUpdateAdminCheck;
use app\exception\SucceedMessage;
use app\exception\UserException;
use think\Controller;
use app\admin\model\Admin as adminModel;
use think\Exception;

class Admin extends Base {
    public function index() {
        $admins = adminModel::all();
        return $this->fetch('', [
            'admins' => $admins,
        ]);
    }

    public function add() {
        return $this->fetch();
    }

    public function create() {
        (new CreateOrUpdateAdminCheck())->goCheck();
        $model  = new adminModel();
        $data   = $this->request->post();
        $result = $model->createNewAdmin($data);
        if ($result) {
            throw new SucceedMessage();
        } else {
            throw new UserException();
        }
    }

    public function edit($id) {
        $admin = adminModel::get($id);
        return $this->fetch("", [
            'id'    => $id,
            'admin' => $admin
        ]);
    }

    public function update($id) {
        (new CreateOrUpdateAdminCheck())->goCheck();
        $model  = new adminModel();
        $data   = $this->request->post();
        $result = $model->updateAdmin($id, $data);
        if ($result) {
            throw new SucceedMessage();
        } else {
            throw new UserException();
        }
    }

    public function delete($id) {
        $result = adminModel::destroy($id);
        if ($result) {
            throw new SucceedMessage();
        } else {
            throw new UserException([
                'msg' => '删除失败'
            ]);
        }
    }

}