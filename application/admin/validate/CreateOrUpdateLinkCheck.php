<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/15
 * Time: 21:01
 */

namespace app\admin\validate;


class CreateOrUpdateLinkCheck extends BaseValidate {
    protected $rule = [
        'name' => 'require',
        'url' => 'require',
        'class_id' => 'require|number',
    ];
    protected $message = [
    ];
}