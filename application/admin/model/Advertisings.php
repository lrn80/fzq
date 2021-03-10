<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/9
 * Time: 20:51
 */

namespace app\admin\model;


use app\admin\service\DeleteFileService;
use app\admin\service\FileUploadService;
use app\exception\AdvertisingException;
use think\Model;

class Advertisings extends Model {
    public function createAD($data){
//        try{
            $image_url = FileUploadService::imgUpload('advertisement');
            $create_arr = [
                'title' => $data['title'],
                'ad_url' => $data['url'],
                'location' => $data['location'],
                'rank' => $data['rank'],
                'expired' => $data['expired'],
                'abstract' => $data['abstract'],
                'image_url' => $image_url,
            ];
            $result = self::create($create_arr);
            if ($result){
                return true;
            }else{
                return false;
            }
//        }catch (\Exception $e){
//            throw new AdvertisingException([
//               'msg' => '广告添加异常'
//            ]);
//        }

    }

    public function updateAD($id, $data){
        $update_data = [
            'id' => $id,
            'title' => $data['title'],
            'ad_url' => $data['url'],
            'location' => $data['location'],
            'rank' => $data['rank'],
            'expired' => $data['expired'],
            'abstract' => $data['abstract'],
        ];
        if (!empty($data['uploadfile'])){
            $ad = self::get($id);
            DeleteFileService::deleteImage($ad['image_url']);
            $image_url = FileUploadService::imgUpload('advertisement');
            $update_data['image_url'] = $image_url;
        }
//        try{
        $result = self::update($update_data);
        if ($result){
            return true;
        }else{
            return false;
        }
//        }catch (\Exception $e){
//            throw new ArticleException([
//                'msg' => '文章添加异常'
//            ]);
//        }
    }

    public static function deleteAndImage($id){
        $data = self::get($id)->toArray();
        DeleteFileService::deleteImage($data['image_url']);
        $result = self::where('id','=',$id)
            ->delete();
        if ($result){
            return true;
        }else{
            return false;
        }
    }
}