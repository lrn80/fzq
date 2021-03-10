<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:34
 */

namespace app\admin\controller;


use app\admin\model\Advertisings;
use app\admin\validate\CreateOrUpdateADCheck;
use app\api\validate\IDCheck;
use app\exception\AdvertisingException;
use app\exception\SucceedMessage;
use think\Controller;
use think\Request;

class Advertisement extends Base
{
    public function index(){
        $ads = Advertisings::all();
        return $this->fetch("", [
            'ads' => $ads,
        ]);
    }

    public function add(){
        return $this->fetch();
    }

    public function create(){
        (new CreateOrUpdateADCheck())->goCheck();
        $model = new Advertisings();
        $data = $this->request->post();
        $result = $model->createAD($data);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new AdvertisingException();
        }
    }

    public function edit($id){
        $ad = Advertisings::get($id);
        //处理时间后台input中显示
        $ad['expired'] = str_replace(" ", "T", $ad['expired']);
        return $this->fetch("", [
            'ad' => $ad,
            'id' => $id
        ]);
    }

    public function update($id){
        (new CreateOrUpdateADCheck())->goCheck();
        $model = new Advertisings();
        $data = $this->request->post();
        $result = $model->updateAD($id, $data);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new AdvertisingException();
        }
    }

    public function delete($id){
        $result = Advertisings::deleteAndImage($id);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new AdvertisingException([
                'msg' => '删除失败'
            ]);
        }
    }

    public function soldOut($id){
        //过期时间设定为此时，即下架。
        $date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
        $result = Advertisings::update([
            'id' => $id,
            'expired' => $date,
        ]);
        if ($result){
            throw new SucceedMessage([
                'msg' => $date,
            ]);
        }else{
            throw new AdvertisingException();
        }
    }

}