<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/6
 * Time: 21:14
 */

namespace app\admin\controller;


use app\admin\model\Categorys;
use app\admin\validate\CreateCategoryCheck;
use app\exception\CategoryException;
use app\exception\SucceedMessage;
use think\Controller;
use app\admin\model\Categorys as CategoryModel;
use think\Exception;
use think\exception\ErrorException;
use think\Request;

class Category extends Base {
    public function add(){
        $model = new CategoryModel();
        $categorys = $model->getCategoryByHaveChild();
        return $this->fetch('category/category-add', [
            'categorys' => $categorys,
        ]);
    }

    public function categoryadd(){
        (new CreateCategoryCheck())->goCheck();
        $data = \request()->post();
        Categorys::createCategory($data);
        throw new SucceedMessage();
    }

    public function categoryEdit($id) {
        $model = new CategoryModel();
        if ($_POST) {
            $result = $model->updateCategory($id, $_POST);
            if ($result) {
                //成功返回
                return json_encode([
                    'code' => 1,
                ]);
            } else {
                //错误返回
                return json_encode([
                    'code' => 0,
                ]);
            }
        } else {
            $category = $model->find($id);
            return $this->fetch('category/category-edit', [
                'id'  => $id,
                'category'  => $category,
            ]);
        }
    }

    public function categoryOrderEdit($id){
        $model = new CategoryModel();
        if ($_POST) {
            $result = $model->updateCategoryOrder($id, $_POST);
            if ($result) {
                //成功返回
                return json_encode([
                    'code' => 1,
                ]);
            } else {
                //错误返回
                return json_encode([
                    'code' => 0,
                ]);
            }
        } else {
            $category = $model->find($id);
            return $this->fetch('category/categoryOrder-edit', [
                'id'  => $id,
                'category'  => $category,
            ]);
        }
    }

    public function delete($id){
        $result = Categorys::destroy($id);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new CategoryException([
                'msg' => '删除异常'
            ]);
        }
    }

    public function order(){
        $model = new Categorys();
        $categorys = $model->getCategoryByFather();
        return $this->fetch("", [
            'categorys' => $categorys
        ]);
    }
}