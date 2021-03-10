<?php


namespace app\api\controller\v1;


use app\api\model\Article as ArticleModel;
use app\api\validate\ArticleCateCheck;
use app\api\validate\ArticleIdCheck;
use app\api\validate\ArticlePageCheck;
use app\api\validate\ArticleCateIdIntCheck;
use app\api\validate\ArticleTagStrCheck;
use app\exception\MissException;
use think\Controller;

class Article extends Controller
{
    //首页左边数据
    public function leftIndex(){

           $leftindex = ArticleModel::indexLeftArticle();
        if (!$leftindex ) {
            throw new MissException([
                'msg' => '请求页面不存在',
                'errorCode' => 20000
            ]);
        }
           return json($leftindex);
    }
    //首页右边数据
    public function rightIndex(){

        $rightindex = ArticleModel::indexRightArticle();
        if (!$rightindex ) {
            throw new MissException([
                'msg' => '请求页面不存在',
                'errorCode' => 20000
            ]);
        }
        return json($rightindex);
    }
    //首页-点击子分类的查询结果
    public function cateArticle($cid,$limit)
    {
        $validate = new ArticleCateCheck();
        $validate->goCheck();
        $article = ArticleModel::clickerChild($cid,$limit);
        if (!$article) {
//            throw new MissException([
//                'msg' => '请求分类内容不存在',
//                'errorCode' => 20000
//            ]);
            return json([]);
        }
        return json($article);
    }
//    //获取除了有子类的其它分类的id
    public  function  getCateId(){
        $result = ArticleModel::Sidebar();
        return json($result);
    }
    //新闻的列表页 需要传的值为整型（没有子分类）
    public  function  newsListInt($cateid,$page){
        $validate = new ArticleCateIdIntCheck();
        $validate->goCheck();
        $resultArticle = ArticleModel::articleListInt($cateid,$page);
        if (!count($resultArticle)) {
//            throw new MissException([
//                'msg' => '请求的页面内容不存在',
//                'errorCode' => 20000
//            ]);
            return json([]);
        }

        return json($resultArticle);
    }
    //最热新闻
    public  function  theHotNews($page){
        $validate = new ArticlePageCheck();
        $validate->goCheck();
        $result = ArticleModel::theHotNews($page);
        if (!count($result)) {
            throw new MissException([
                'msg' => '请求的最热新闻内容出错了',
                'errorCode' => 20000
            ]);
        }
        return json($result);
    }

    //图文落地页左边文章内容
    public  function  imageText($articleId){
        $validate =new ArticleIdCheck();
        $validate->goCheck();
        $result = ArticleModel::imageText($articleId);
        if (!count($result)) {
            throw new MissException([
                'msg' => '请求的图文页面内容丢失or不存在',
                'errorCode' => 20000
            ]);
        }
        return json($result);
    }
  //热门文章
    public  function  pushHotNews($page){
        $validate = new ArticlePageCheck();
        $validate->goCheck();
        $result = ArticleModel::pushHotNews($page);
        if (!count($result)) {
            throw new MissException([
                'msg' => '请求的热门文章list出错了 or 已经没有数据',
                'errorCode' => 20000
            ]);
        }
        return json($result);
    }
   // 推荐模块左边的部分
    public function pushLeftIndex(){
        $result=ArticleModel::pushIndex();
        if (!count($result)) {
            throw new MissException([
                'msg' => '你请求的数据丢失或不存在',
                'errorCode' => 20000
            ]);
        }
        return json($result);
    }
    //精品推荐
    public function tuiJian(){
        $cate = ArticleModel::choiceRecomm();
        if (!count($cate)) {
            throw new MissException([
                'msg' => '你请求的数据丢失或不存在',
                'errorCode' => 20000
            ]);
        }
        return json($cate);
    }

}