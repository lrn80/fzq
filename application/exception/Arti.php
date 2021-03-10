<?php
/**
 * User: xiaomin
 * Date: 2019/11/11
 * Time: 9:24
 */

namespace app\exception;


class Arti extends BaseException
{
    public $code = "404";
    public $msg = "请求的文章没有找打";
    public $errorCode = "404";

}