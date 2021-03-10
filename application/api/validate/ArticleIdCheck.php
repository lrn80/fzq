<?php


namespace app\api\validate;


class ArticleIdCheck extends BaseValidate
{
    protected $rule = [
        'articleId' => 'isMustInteger'

    ];

    protected $message = [
        'articleId'  => '你要查询的文章id必须为正整数'
    ];
}