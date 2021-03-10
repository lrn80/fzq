<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/11/8
 * Time: 20:22
 */

namespace app\admin\service;


use app\exception\UploadException;

class FileUploadService {
    public static function imgUpload($dir) {
        if (!isset($_FILES["uploadfile"])) {
            return "/upload/article/74902653_p0.jpg";
        }
        // 允许上传的图片后缀
        $allowedExts = array("gif", "jpg", "jpg", "png");
        $temp        = explode(".", $_FILES["uploadfile"]["name"]);
        $extension   = end($temp);     // 获取文件后缀名
        if ((($_FILES["uploadfile"]["type"] == "image/gif")
                || ($_FILES["uploadfile"]["type"] == "image/jpeg")
                || ($_FILES["uploadfile"]["type"] == "image/jpg")
                || ($_FILES["uploadfile"]["type"] == "image/pjpeg")
                || ($_FILES["uploadfile"]["type"] == "image/x-png")
                || ($_FILES["uploadfile"]["type"] == "image/png"))
            && ($_FILES["uploadfile"]["size"] < 409600)   // 小于 400 kb
            && in_array($extension, $allowedExts)) {
            if ($_FILES["uploadfile"]["error"] > 0) {
            } else {
                if ($_FILES["uploadfile"]["size"] > 204800){
                    $filename = md5($_SERVER['REQUEST_TIME'] . $_FILES["uploadfile"]["name"] ). "." . $extension;
                    move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/{$dir}/" . $filename);
                    (new imgCompress("upload/{$dir}/".$filename, 0.5))->compressImg("upload/{$dir}/".$filename);
                    return "/upload/{$dir}/" . $filename;
                }else{
                    $filename = md5($_SERVER['REQUEST_TIME'] . $_FILES["uploadfile"]["name"] ). "." . $extension;
                    move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/{$dir}/" . $filename);
                    return "/upload/{$dir}/" . $filename;
                }
            }
        } else {
            throw new UploadException([
                'msg' => '上传图片格式不规范（请上传"gif", "jpeg", "jpg", "png"格式）或者图片大小大于400kb'
            ]);
        }
    }
}