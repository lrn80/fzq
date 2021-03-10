<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
    protected  $rule = [
      ['name','require']
    ];
}