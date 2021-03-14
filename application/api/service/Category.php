<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\api\service;
use app\api\model\Category as CategoryModel;

class Category
{
    public static function getCategoryList()
    {
        $category_model = new CategoryModel();
        return $category_model->getCategoryList([], ['id', 'cname']);
    }
}