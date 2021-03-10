<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/9
 * Time: 14:26
 */

namespace app\admin\validate;


class CreateArticleCheck extends BaseValidate {
    protected $rule = [
        'articletitle' => 'require',
        'articletype' => 'require',
        'recommend' => 'require',
        'abstract' => 'require',
        'author' => 'require',
    ];
    protected $message = [
    ];
}
