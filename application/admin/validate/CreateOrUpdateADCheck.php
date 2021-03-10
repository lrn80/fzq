<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/10
 * Time: 12:56
 */

namespace app\admin\validate;


class CreateOrUpdateADCheck extends BaseValidate {
    protected $rule = [
        'title' => 'require',
        'url' => 'require|url',
        'location' => 'require',
        'rank' => 'require',
        'expired' => 'require',
        'abstract' => 'require',
    ];
    protected $message = [
    ];
}