<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 13:45
 */

namespace app\admin\controller;


use think\Controller;

class Index extends  Base
{
    public function index(){
       return $this->fetch() ;
    }

    public function welcome(){
        return $this->fetch() ;
    }

}