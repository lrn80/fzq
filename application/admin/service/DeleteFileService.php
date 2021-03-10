<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/26
 * Time: 21:16
 */

namespace app\admin\service;


use think\Exception;
use think\File;

class DeleteFileService {
    public static function deleteImage($filename){
        $filename = ROOT_PATH.'public'.$filename;
        if (is_file($filename)){
            try{
                unlink($filename);
            }catch (Exception $e){
            }
            return true;
        }
        return true;
    }
}