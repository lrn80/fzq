<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 14:02
 */

namespace app\api\validate;


class RegisterCheck extends BaseValidate {
    protected $rule = [
        'username' => 'require|checkStandard',
        'phonenumber' => 'require|length:11|number',
        'password' => 'require|max:12|min:5',
        're_password' => 'require|max:12|min:5',
    ];
    protected $message = [
        'username.checkStandard' => '命名不规范'
    ];
}