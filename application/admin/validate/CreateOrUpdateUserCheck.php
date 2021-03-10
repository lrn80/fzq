<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/10
 * Time: 12:56
 */

namespace app\admin\validate;


class CreateOrUpdateUserCheck extends BaseValidate {
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'mobile' => 'require',
    ];
    protected $message = [
    ];
}