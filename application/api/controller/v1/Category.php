<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Category as CategoryService;

class Category extends BaseController
{
    public function getCategoryList()
    {
        return json(CategoryService::getCategoryList());
    }
}