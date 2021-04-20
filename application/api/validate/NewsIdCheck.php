<?php


namespace app\api\validate;


class NewsIdCheck extends BaseValidate
{
    protected $rule = [

        'news_id'=>'require|isMustInteger'
    ];
    protected $message = [

        'news_id'=>'news_id不合法'
    ];
}