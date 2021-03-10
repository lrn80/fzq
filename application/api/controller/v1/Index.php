<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/5/31
 * Time: 22:04
 */

namespace app\api\controller\v1;

use app\api\model\Discount;
use app\api\model\User as UserModel;
use app\api\model\Advertising;
use app\api\model\Driver;
use app\api\model\Enroll;
use app\api\validate\EnrollCheck;
use app\api\validate\IDCheck;
use app\exception\SuccessMessage;


class Index
{
    public function index($id){
        echo $_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"];
    }
}