<?php
/**
 * User: xiaomin
 * Date: 2019/11/8
 * Time: 12:41
 */

namespace app\admin\controller;


use think\Controller;

class  Base extends Controller
{

    public  function _initialize()
    {
        if (!$this->islogin()){
            return $this->redirect("login/index");
        }
    }

    /**判断是否登录
     * @return bool
     */
    public function islogin(){
        $sesson = session(config('admin.session_user'),'',config('admin.session_user_scope'));
        if ($sesson && $sesson->id){
            return true;
        }else{
            return false;
        }
    }



}