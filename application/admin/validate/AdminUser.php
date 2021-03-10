<?php
/**
 * User: xiaomin
 * Date: 2019/10/4
 * Time: 11:08
 */

namespace app\common\validate;


use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'username' =>"require|max:20",
        'password' =>"require|max:20",
    ];
}