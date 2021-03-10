<?php


namespace app\api\validate;


class ArticlePageCheck extends  BaseValidate
{
    protected $rule = [

        'page'=>'require|isMustInteger'
    ];
    protected $message = [

        'page'=>'page不是正整数'
    ];
}