<?php
/**
 * Created by PhpStorm.
 * User: θηδΈη¨
 * Date: 2019/11/23
 * Time: 11:34
 */

namespace app\index\controller;


use think\Controller;

class Index extends Controller {
    public function Index(){
        return $this->fetch();
    }
}