<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/9
 * Time: 14:26
 */

namespace app\admin\validate;


class CreateCategoryCheck extends BaseValidate {
    protected $rule = [
        'name' => 'require',
        'category' => 'number',
        'read' => 'number',
    ];
    protected $message = [
    ];
}
