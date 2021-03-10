<?php


namespace app\exception;


class MissException extends BaseException
{
    public $code = "400";
    public $msg = "请求的页面不存在";
    public $errorCode = "20000";
}