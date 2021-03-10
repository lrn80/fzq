<?php
/**
 * User: xiaomin
 * Date: 2019/11/9
 * Time: 20:31
 */

namespace app\api\controller\v1;
use app\api\validate\Arti as ArtiValidate;
use sphinx\SphinxClient;
use app\exception\Arti as ArtiException;

class Arti
{

//    public function getSphinx($content){
//        error_reporting(0);
//        $sc = new SphinxClient();
//        $sc->setServer('localhost',9312);
//        //$sc->SetLimits ( 0,10 , 1000,50);
//        $sc->setMatchMode(SPH_MATCH_ALL);
//       // halt($content['content']);
//        $keyword = $content['content'];
//        //halt($keyword);
//        $indexName = 'article';
//        $res = $sc->query($keyword,$indexName);
//       // halt($res);
//        $ids = implode(',',array_keys($res['matches']));
//        return $ids;
//    }


    public function getSearchArticle(){
        $artiValidate = new ArtiValidate();
        $artiValidate->goCheck();
        $content = input("post.content");
        $page = input("post.page");
       // halt($id);
        $data = model('Arti')->getSearchArticle($content,$page);
        //halt($data['article']);
        if (!$data){
            throw new ArtiException();
        }
        $articleNumber = count($data['article']);
        if ($articleNumber!= config('apicode.article_number')){
            $reuslt = [
                'article' => $data['article'],
                'count' => $data['count'],
                'ArticleNumber' => 'ArticleNull',
            ];
        }else{
            $reuslt = [
                'article' => $data['article'],
                'count' => $data['count'],
            ];
        }
        //halt($reuslt);
        return json($reuslt,200);
    }





}