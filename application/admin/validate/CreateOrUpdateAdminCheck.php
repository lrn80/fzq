<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/10
 * Time: 12:56
 */

namespace app\admin\validate;


class CreateOrUpdateAdminCheck extends BaseValidate {
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
    ];
    protected $message = [
    ];
}