<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:45
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Base
{
    /**
     * 重写父类的init方法
     */
    public function _initialize(){}


    public function index(){
        if ($this->islogin()){
            return $this->redirect("index/index");
        }
        return $this->fetch();
    }

    /**
     * 验证登录相关逻辑
     */
    public function check(){
        if (Request()->isPost()){
            $data = input("post.");
            //halt($data);
            //判断验证码是否正确
            if (!captcha_check($data['code'])){
                return $this->error("验证码不正确");
            }
            $validate = validate('AdminUser');
            if (!$validate->check($data)){
                return $this->error($validate->getError());
            }
            try{
                //halt($data['username']);
                $user = model("Admin")->get(['username'=>$data['username']]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
                // halt()$e->getMessage();
            }

            if (!$user || $user->status!=config('code.user_normal')){
                $this->error("该用户不存在或密码错误");
            }
            if( $user->password != md5($data['password'])){
                $this->error("用户的密码错误");
            }
            $update =[
                'last_login_time' =>time(),
                'last_login_ip' =>request()->ip()
            ];
            try{
                model("Admin")->save($update,['id'=>$user->id]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            // 设置session
            session(config('admin.session_user'), $user, config('admin.session_user_scope'));
            $this->success("登录成功",'index/index');

        }else{
            return $this->error("登录失败！");
        }

    }

    /**
     * 退出登录的逻辑
     * 1、清空session
     * 2、 跳转到登录页面
     */
    public function logout() {
        session(null, config('admin.session_user_scope'));
        // 跳转
        $this->redirect('login/index');
    }

}