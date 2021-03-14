<?php


namespace app\api\validate;


class NewsIdCheck extends BaseValidate
{
    protected $rule = [
        'news_id' => 'isMustInteger'

    ];

    protected $message = [
        'news_id'  => '你要查询的文章id必须为正整数'
    ];
}