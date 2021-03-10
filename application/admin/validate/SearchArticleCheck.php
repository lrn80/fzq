<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/9
 * Time: 14:26
 */

namespace app\admin\validate;


class SearchArticleCheck extends BaseValidate {
    protected $rule = [
        'category' => 'number',
        'start' => 'date',
        'end' => 'date',
        'title' => 'max:60',
    ];
    protected $message = [
    ];
}
