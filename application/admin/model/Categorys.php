<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/6
 * Time: 21:25
 */

namespace app\admin\model;


use think\Exception;
use think\Model;

class Categorys extends Model {
    public static function createCategory($date){
        try{
            self::create([
                'pid' => $date['category'],
                'tag' => $date['name'],
                'view' => $date['read'],
            ]);
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function handlePTag(){
        $categorys = $this->select()->toArray();
        if ($categorys){
            $format = [];
            foreach ($categorys as $category){
                if ($category['pid'] == 0){
                    $category['p_tag'] = '无';
                    $format[] = $category;
                    foreach ($categorys as $c){
                        if ($c['pid'] == $category['id']){
                            $c['p_tag'] = $category['tag'];
                            $format[] = $c;
                        }
                    }
                }
            }
            return $format;
        }else{
            return false;
        }
    }


    public function getCategoryByChild(){
        $categorys = $this->select()->toArray();
        if ($categorys){
            $format = [];
            foreach ($categorys as $category){
                if ($category['pid'] == 0){
                    $format[] = $category;
                    foreach ($categorys as $c){
                        if ($c['pid'] == $category['id']){
                            $c['tag'] = $category['tag']."--".$c['tag'];
                            $format[] = $c;
                        }
                    }
                }
            }
            return $format;
        }else{
            return false;
        }
    }

    public function getCategoryByHaveChild(){
        $categorys = $this->where('pid', '=', 0)
            ->select();
        if (!$categorys){
            return false;
        }
        return $categorys;
    }

    //格式化分类，在选择分类时方便选择
    public function getTreeCategory(){
        $categorys = $this->select();
    }

    public function updateCategory($id, $data){
        $category = [
            'id' => intval($id),
            'tag' => $data['name'],
            'view' => intval($data['read'])
        ];
        try{
            self::update($category);
            return true;
        }catch (Exception $e){
            return false;
        }

    }

    public function updateCategoryOrder($id, $data){
        $category = [
            'id' => intval($id),
            'tag' => $data['name'],
            'sort' => intval($data['sort'])
        ];
        try{
            self::update($category);
            return true;
        }catch (Exception $e){
            return false;
        }

    }

    public function getCategoryByFather(){
        $categorys = $this->where('pid', '=', 0)
            ->order('sort', 'asc')
            ->select();
        if (!$categorys){
            return false;
        }
        return $categorys;
    }
}