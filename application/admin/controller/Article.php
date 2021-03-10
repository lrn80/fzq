<?php
/**
 * User: xiaomin
 * Date: 2019/11/7
 * Time: 17:08
 */

namespace app\admin\controller;


use app\admin\model\Articles;
use app\admin\model\Categorys;
use app\admin\service\CategoryService;
use app\admin\validate\CreateArticleCheck;
use app\admin\validate\SearchArticleCheck;
use app\exception\ArticleException;
use app\exception\SucceedMessage;
use think\Controller;
use think\Db;
use think\Debug;
use think\Exception;
use app\admin\model\Articles as ArticleModel;
use think\Request;
use think\response\Json;
use think\Session;

class Article extends Base
{
    public function index(){
        if (\request()->isPost()){
            (new SearchArticleCheck())->goCheck();
            $data = \request()->post();
            Session::set('category', $data['category']);
            Session::set('start', $data['start']);
            Session::set('end', $data['end']);
            Session::set('title', $data['title']);
        }
        //pv是访问量
        $articles = Articles::getAllArticle();
//        $articles=Db::query("select article.id as id,article.cate_id as cate_id,image_url,author,title,pv,article.create_time,tag,recommend
//                              from article,categorys
//                              where article.cate_id=categorys.id
//                              limit 10");
        $categorys = (new Categorys())->getCategoryByChild();
        $this->assign('articles',$articles);
        $this->assign('categorys',$categorys);
        $total = ($articles->toArray())['total'];
//        $this->assign('articles',$articles);
        return $this->fetch('',[
            'cate_id' => Session::get('category'),
            'start' => Session::get('start'),
            'end' => Session::get('end'),
            'title' => Session::get('title'),
            'total' => $total,
        ]);
    }

    public function add(){
        $data = Categorys::all();
        $categorys = CategoryService::FormattingCategory($data);
        return $this->fetch("", [
            'categorys' => $categorys,
        ]);
    }

    public function create(){
        (new CreateArticleCheck())->goCheck();
        $article = new ArticleModel();
        $result = $article->createNewArticle($_POST);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new ArticleException();
        }
    }

    public function edit($id, $cate_id, $recommend_id){
        $article = ArticleModel::get($id);
        $data = Categorys::all();
        $categorys = CategoryService::FormattingCategory($data);
        return $this->fetch('', [
            'article' => $article,
            'categorys' => $categorys,
            'id' => $id,
            'cate_id' => $cate_id,
            'recommend_id' => $recommend_id
        ]);
    }

    public function update($id){
        (new CreateArticleCheck())->goCheck();
        $article = new ArticleModel();
        $result = $article->updateArticle($id, $_POST);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new ArticleException();
        }
    }

    public function delete($id, $cate_id){
        $result = ArticleModel::deleteAndImage($id, $cate_id);
        if ($result){
            throw new SucceedMessage();
        }else{
            throw new ArticleException([
                'msg' => '删除失败'
            ]);
        }
    }

    //要闻推荐
    public function News(){
//        Debug::remark('begin');
        $articles = Db::query("select article.id as id,article.cate_id as cate_id,image_url,author,title,pv,article.create_time,tag,recommend
                              from article,categorys
                              where article.cate_id=categorys.id
                              and recommend = 2");
//        Debug::remark('end');
//        echo Debug::getRangeTime('begin','end')."S";
        return $this->fetch("",[
            'articles' => $articles,
        ]);
    }

    //专题推荐
    public function Topic(){
        $articles = Db::query("select article.id as id,article.cate_id as cate_id,image_url,author,title,pv,article.create_time,tag,recommend
                              from article,categorys
                              where article.cate_id=categorys.id
                              and recommend = 1");
        return $this->fetch("",[
            'articles' => $articles,
        ]);
    }

    //视频推荐
    public function Video(){

    }
    public function classify(){
        $model = new Categorys();
        $categorys = $model->handlePTag();
        if ($categorys) {
            return $this->fetch('', [
                'categorys' => $categorys,
            ]);
        } else {
            throw new Exception();
        }
    }

}