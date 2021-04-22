<?php
/**
 * User: ruoning
 * Date: 2021/4/22
 * motto: 知行合一!
 */


namespace app\api\validate;


class UserCheck extends BaseValidate
{
    protected $rule = [
        'username' => 'max:50|min:1',
        'sex' => 'in:1,2',
        'birth' => 'dateFormat:Y-m-d'
    ];

    protected $message = [
        'birth' => 'birth格式必须是YYYY-mm-dd格式'
    ];
}