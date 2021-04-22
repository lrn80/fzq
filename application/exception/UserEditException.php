<?php
/**
 * User: ruoning
 * Date: 2021/4/22
 * motto: 知行合一!
 */


namespace app\exception;


class UserEditException extends BaseException
{
    public $code = "400";
    public $msg = "用户信息修改失败，请稍后再试";
    public $errorCode = "10003";
}