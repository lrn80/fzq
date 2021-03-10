<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:34
 */

namespace app\admin\controller;


use app\admin\validate\CreateOrUpdateLinkCheck;
use app\exception\LinkException;
use app\exception\SucceedMessage;
use think\Controller;
use think\Request;
use app\admin\model\Links;

class Link extends Base
{
    public function index(){
        $links = Links::all();
        return $this->fetch("", [
            'links' => $links,
        ]);
    }

    public function add(){
        return $this->fetch();
    }

    public function create(){
        (new CreateOrUpdateLinkCheck())->goCheck();
        $data = $this->request->post();
        $result = Links::create([
            'link_name' => $data['name'],
            'link_url' => $data['url'],
            'class_id' => $data['class_id'],
        ]);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new LinkException();
        }
    }

    public function edit($id){
        $link = Links::get($id);
        return $this->fetch("", [
            'link' => $link,
            'id' => $id
        ]);
    }

    public function update($id){
        (new CreateOrUpdateLinkCheck())->goCheck();
        $data = $this->request->post();
        $result = Links::update([
            'id' => $id,
            'link_name' => $data['name'],
            'link_url' => $data['url'],
            'class_id' => $data['class_id'],
        ]);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new LinkException();
        }
    }

    public function delete($id){
        $result = Links::destroy($id);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new LinkException([
                'msg' => '删除失败'
            ]);
        }
    }

}