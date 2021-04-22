<?php


namespace app\exception;


class NewsUpvoteNotException extends BaseException
{
    public $code = "400";
    public $msg = "点赞已经删除，请勿重复操作";
    public $errorCode = "10004";
}