<?php


namespace app\exception;


class DiscussNotUpvoteException extends BaseException
{
    public $code = "400";
    public $msg = "取消点赞成功，请勿重复操作";
    public $errorCode = "70004";
}