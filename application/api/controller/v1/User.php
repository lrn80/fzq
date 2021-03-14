<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/20
 * Time: 17:01
 */

namespace app\api\controller\v1;

use app\api\service\TokenUser;
use app\api\validate\LoginCheck;
use app\api\validate\RegisterCheck;
use app\exception\LoginException;
use app\exception\RegisterException;
use app\exception\SucceedMessage;
use app\exception\UserException;
use think\Cache;
use think\Exception;
use think\Request;
use app\api\service\User as UserService;
use \app\api\service\Email;
class User {
    protected $user;

    /**
     * 用户登陆接口
     * @throws Exception
     * @throws LoginException
     * @throws SucceedMessage
     * @throws \app\exception\ParamException
     */
    public function login() {
        (new LoginCheck())->goCheck();
        $params = request()->param();

        $succ = UserService::find($params);
        if ($succ) {
            throw new SucceedMessage();
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

    /**
     * 用户注册接口
     * @throws Exception
     * @throws RegisterException
     * @throws SucceedMessage
     * @throws UserException
     * @throws \app\exception\ParamException
     */
    public function register() {
        (new RegisterCheck())->goCheck();
        if ($_POST['password'] !== $_POST['re_password']){
            throw new RegisterException([
                'msg' => '两次密码不一致'
            ]);
        }
        $params = request()->post();
        $verify = Email::verifyCode($params);
        if (!$verify) {
            throw new RegisterException([
                'mag' => '验证码错误'
            ]);
        }

        $succ = UserService::saveUserInfo($params);
        if ($succ){
            throw new SucceedMessage();
        }else{
            throw new UserException();
        }
    }

    public function getUserInfo() {
        return TokenUser::getInfoByTokenVar();
    }
}