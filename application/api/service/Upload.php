<?php


namespace app\api\service;


use think\Log;

class Upload
{
    public static function uploadImg($imgUrl, $fileName)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($fileName);

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move($imgUrl);
            if($info){
//                // 成功上传后 获取上传信息
//                // 输出 jpg
//                echo $info->getExtension();
//                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
//                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
                Log::info(__METHOD__ . " upload image name:{$info->getSaveName()}");
                return $info->getFilename();
            }else{
                // 上传失败获取错误信息
                Log::error(__METHOD__ . "upload fail image errorInfo:{$info->getError()}");
                return false;
            }
        }
    }
}