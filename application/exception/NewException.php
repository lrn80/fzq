<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */


namespace app\exception;


class NewException extends BaseException
{
    public $code = "400";
    public $msg = "文章异常";
    public $errorCode = "10000";
}