<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/4/14
 * Time: 13:14
 */

namespace app\exception;


class ArticleException extends BaseException
{
    public $code = "400";
    public $msg = "文章异常";
    public $errorCode = "10000";
}