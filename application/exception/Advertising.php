<?php
/**
 * User: xiaomin
 * Date: 2019/11/9
 * Time: 14:12
 */

namespace app\exception;


class Advertising extends BaseException
{
    public $code = "404";
    public $msg = "请求的广告数据没有或没有找到";
    public $errorCode = "404";
}