<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/20
 * Time: 17:01
 */

namespace app\api\controller\v1;

use app\api\validate\LoginCheck;
use app\api\model\User as UserModel;
use app\api\validate\RegisterCheck;
use app\exception\LoginException;
use app\exception\RegisterException;
use app\exception\SucceedMessage;
use app\api\service\TokenUser;
use app\exception\UserException;
use think\Cache;
use think\Config;
use think\Exception;
use think\Request;

class User {
    protected $user;

    public function login() {
        (new LoginCheck())->goCheck();
        $model = new UserModel();
        $user  = $model->loginCheck($_POST);
        if ($user) {
            throw new SucceedMessage([
                'msg' => (new TokenUser($user))->get()
            ]);
        } else {
            throw new LoginException();
        }
    }

    public function logout() {
        $token  = Request::instance()->header("token");
        $result = Cache::rm($token);
        if ($result) {
            throw new SucceedMessage();
        } else {
            throw new Exception('退出异常');
        }
    }

    public function register() {
        (new RegisterCheck())->goCheck();
        $model = new UserModel();
        if ($_POST['password'] !== $_POST['re_password']){
            throw new RegisterException([
                'msg' => '两次密码不一致'
            ]);
        }
        $result = $model->createNewUser($_POST);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new UserException();
        }
    }

    public function getUserInfo() {
        return TokenUser::getInfoByTokenVar();
    }
}