<?php
/**
 * User: xiaomin
 * Date: 2019/11/9
 * Time: 11:05
 */

namespace app\api\controller\v1;


use app\exception\Advertising as AdvertisingEception;
use app\api\validate\IDCheck;

class Advertising
{

    public function getListAdvertising($id){
//        $AdvertiseValidate = new IDCheck();
//        $AdvertiseValidate->goCheck();
//        $result =[];
//        if ($id == config("apicode.home_advertising")){
//            $result = model('Adverstising')->getHomeAdver();
//        }else if($id == config('apicode.list_advertising')){
//            $result = model('Adverstising')->getRecommendAdver();
//        }
//        //halt($result);
//        if (!$result){
//            throw new AdvertisingEception();
//        }
//       // halt($result);
//        $data = ['Advertisement'=>$result];
//        return json($data);
    }


}