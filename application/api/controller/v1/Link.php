<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/18
 * Time: 16:46
 */

namespace app\api\controller\v1;


use app\api\model\Links;
use app\exception\MissException;
use think\Controller;

class Link extends Controller {
    public function getLinkLeft(){
        $links = Links::where('class_id',0)
            ->select();
        if (!$links){
            throw new MissException([
                'msg' => '请求页面不存在',
                'errorCode' => 20000
            ]);
        }
        return json($links);
    }

    public function getLinkRight(){
        $links = Links::where('class_id',1)
            ->select();
        if (!$links){
            throw new MissException([
                'msg' => '请求页面不存在',
                'errorCode' => 20000
            ]);
        }
        return json($links);
    }

    public function getLinks(){
        $links_left = Links::where('class_id',0)
            ->limit(5)
            ->select()
            ->toArray();
        $links_right = Links::where('class_id',1)
            ->limit(5)
            ->select()
            ->toArray();
        $links = array_merge($links_left, $links_right);
        foreach ($links as &$link){
            if ($link['class_id'] == 0){
                $link['classname'] = config('mapping.link_0');
            }else{
                $link['classname'] = config('mapping.link_1');
            }
        }
        if (!$links){
            throw new MissException([
                'msg' => '请求页面不存在',
                'errorCode' => 20000
            ]);
        }
        return json($links);
    }
}