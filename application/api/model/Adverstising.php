<?php
/**
 * User: xiaomin
 * Date: 2019/11/9
 * Time: 10:23
 */

namespace app\api\model;


class Adverstising extends BaseModel
{

    protected $table = "advertisings";
    protected $hidden=['delete_time','img_id','id','update_time',"is_online",'location','rank','expired'];

    /**获取列表广告model
     * @param $id 传入id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public  function getImageUrlAttr($value)
    {
        $finalUrl=$this->prefixImgUrl($value);
        return $finalUrl;
    }
    public static function getListAdver($id){
        $start = $id -1;
        $number = config('apicode.advertisingnumber');
        $order =['rank' => 'desc'];
        $result = self::where('expired', '>', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']))
            ->order($order)
            ->limit($start,$number)
            ->select();
        $result=$result->toArray();
        return $result;

    }
     //推荐页面的广告
    public static function getRecommendAdver(){
        $order = ['rank' => 'desc'];
        $location = ['location' => 2];
        $result = self::where($location)
            ->where('expired', '>', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']))
            ->order($order)->limit(1)->select();
        return $result;
    }
    //首页轮播图的广告
    public static function getHomeAdver(){
        $order = ['rank' => 'desc'];
        $location = ['location' => 1];
        $result = self::where($location)
            ->where('expired', '>', date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']))
            ->order($order)->limit(1)->select();
        return $result;
    }


}