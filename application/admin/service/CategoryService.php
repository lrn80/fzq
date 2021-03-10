<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/6
 * Time: 23:00
 */

namespace app\admin\service;


class CategoryService{
    public function ChildTree($data, $pid){
        $tree = [];
        if (!$data && !is_array($data)){
            return false;
        }
    }

    //文章添加分类的下拉栏的样式格式
    public static function FormattingCategory($data){
//        $tree = [];
//        foreach ($data as $v) {
//            if ($v['pid'] == $pid){
//                $tree[$v['id']] = $this->FormattingCategory($data, $v['id']);
//
//            }
//        }
        $tree = [];
        $flag = false;
        foreach ($data as $v) {
            if ($v['pid'] == 0){
                foreach ($data as $vr){
                    if ($vr['pid'] == $v['id']){
                        $flag = true;
                        $tree[$vr['id']] = $v['tag']."--".$vr['tag'];
                    }
                }
                if (!$flag){
                    $tree[$v['id']] = "主分支--".$v['tag'];
                }
                $flag = false;
            }
        }
        return $tree;
    }

}