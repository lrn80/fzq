<?php

namespace app\admin\model;

use app\admin\service\DeleteFileService;
use app\admin\service\FileUploadService;
use app\exception\ArticleException;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\Model;
use think\Session;

class Articles extends Model {
    protected $table = "article";

    public function categorys() {
        return $this->belongsTo('app\admin\model\Categorys', 'cate_id');
    }

    public static function getAllArticle(){
        $whereArr = [];
        $category = Session::get('category');
        if ($category != null){
            $whereArr['cate_id'] = array('eq',$category);
        }

        $start = Session::get('start');
        $end = Session::get('end');
        if ($end != null){
            $whereArr['article.create_time'] = array('between time', [date('Y-m-d H:i:s', strtotime($start)), date('Y-m-d H:i:s', strtotime($end))]);
        }

        $title = Session::get('title');
        if ($title != null){
            $whereArr['title'] = array('like',"%{$title}%");
        }
        $articles = Db::table('article')
            ->join('categorys', 'categorys.id = article.cate_id')
            ->where($whereArr)
            ->field(['article.id as id','article.cate_id as cate_id','image_url','author','title,pv','article.create_time as create_time','tag','recommend'])
            ->order('create_time desc')
            ->paginate(20,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page',
            ]);
        if ($articles){
            return $articles;
        }else{
            throw new Exception();
        }
    }

    public function createNewArticle($data) {
        $image_url = FileUploadService::imgUpload('article');
//        try{
        $result = self::create([
            'title'     => $data['articletitle'],
            'cate_id'   => $data['articletype'],
            'abstract'  => $data['abstract'],
            'author'    => $data['author'],
            'pv'        => $data['pv'],
            'image_url' => $image_url,
            'content'   => $data['editorValue'],
            'recommend' => $data['recommend'],
        ]);
        if ($result) {
            return true;
        } else {
            return false;
        }
//        }catch (\Exception $e){
//            throw new ArticleException([
//                'msg' => '文章添加异常'
//            ]);
//        }

    }

    public function updateArticle($id, $data) {
        $article    = self::get($id);
        $difference = $data['pv'] - $article['pv'];
        try{
            db('categorys')->where('id', $data['articletype'])
                ->setDec('view', $data['pv']);
        }catch (PDOException $e){
            db('categorys')->where('id', $data['articletype'])
                ->update([
                    'view' => 0
                ]);
        }
        $update_data = [
            'id'        => $id,
            'title'     => $data['articletitle'],
            'cate_id'   => $data['articletype'],
            'abstract'  => $data['abstract'],
            'author'    => $data['author'],
            'pv'        => $data['pv'],
            'content'   => $data['editorValue'],
            'recommend' => $data['recommend']
        ];
        if (!empty($data['uploadfile'])) {
            DeleteFileService::deleteImage($article['image_url']);
            $image_url                = FileUploadService::imgUpload('article');
            $update_data['image_url'] = $image_url;
        }
//        try{
        $result = self::update($update_data);
        if ($result) {
            return true;
        } else {
            return false;
        }
//        }catch (\Exception $e){
//            throw new ArticleException([
//                'msg' => '文章添加异常'
//            ]);
//        }
    }

    public static function deleteAndImage($id, $cate_id){
        $data = self::get($id)->toArray();
        try{
            db('categorys')->where('id', $cate_id)
                ->setDec('view', $data['pv']);
        }catch (PDOException $e){
            db('categorys')->where('id', $cate_id)
                ->update([
                    'view' => 0
                ]);
        }
        DeleteFileService::deleteImage($data['image_url']);
        $result = self::where('id','=',$id)
            ->delete();
        if ($result){
            return true;
        }else{
            return false;
        }
    }

    public static function getAllArticleBySearch(){
        $whereArr = [];
        if (Session::get('category') != null){
            $whereArr['cate_id'] = array('eq',Session::get('category'));
        }
        if (Session::get('start') != null){
            $whereArr['start'] = array('egt',Session::get('start'));
        }
        if (Session::get('end') != null){
            $whereArr['end'] = array('elt',Session::get('end'));
        }
        if (Session::get('title') != null){
            $whereArr['title'] = array('like',Session::get('%title%'));
        }
        $articles = Db::table('article')
            ->join('categorys', 'categorys.id = article.cate_id')
            ->where($whereArr)
            ->field(['article.id as id','article.cate_id as cate_id','image_url','author','title,pv','article.create_time as create_time','tag','recommend'])
            ->order('create_time desc')
            ->paginate(20,false,[
                'type'     => 'bootstrap',
                'var_page' => 'page',
            ]);
        if ($articles){
            return $articles;
        }else{
            throw new Exception();
        }
    }
}