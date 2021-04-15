<?php
/**
 * User: ruoning
 * Date: 2021/3/13
 * motto: 知行合一!
 */


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Email as EmailService;
use app\api\validate\EmailCheck;
use app\api\validate\LoginCheck;
use app\exception\EmailException;


class Email extends BaseController
{
    /**
     * 获取验证码
     * @return \think\response\Json
     * @throws EmailException
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     */
    public function getCode()
    {
        (new EmailCheck())->goCheck();
        $params = $this->request->param();
        $code = EmailService::sendCode($params);
        if (!$code) {
            throw new EmailException();
        }

        return json(['code' => $code]);
    }
}