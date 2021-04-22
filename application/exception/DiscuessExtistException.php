<?php


namespace app\exception;


class DiscuessExtistException extends BaseException
{
    public $code = "400";
    public $msg = "已经点过赞了，请勿重复操作";
    public $errorCode = "70003";
}