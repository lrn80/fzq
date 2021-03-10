<?php


namespace app\api\model;
class Article extends BaseModel
{

   public  function getImageUrlAttr($value)
   {
       $finalUrl=$this->prefixImgUrl($value);
       return $finalUrl;
   }

     //精品推荐更多资讯封装
    public  static  function moreBuotique($limit){
        $article=array();
        $category= self::table("categorys")
            ->order("view","desc")
            ->where('id','not in',function($query){
                $query->table('categorys')->field('pid');
            })->where("pid","=","0")
            ->limit($limit)
            ->column('id');
        for($i=0;$i<$limit;$i++){
            $article1=self::table("article")
                ->where("cate_id","=","$category[$i]")
                ->field(['id','title','create_time','image_url'])
                ->limit(1)
                ->order("id","desc")
                ->buildSql();
            $article1=self::table(["categorys"=>"c",$article1."a"])
                ->where("c.id","=","$category[$i]")
                ->field(['c.id'=>'cateid',"tag","view",'a.id','title','a.create_time','image_url'])
                ->limit(1)
                ->select();
            $article1=$article1->toArray();
            $article=array_merge($article,$article1);
        }
        return $article;
    }
    //首页-查询分类id是否有子分类
    public  static  function checkCatePid($pid){
       $res = self::table('categorys')
             ->where('pid','=',$pid)
             ->field(['id'=>'cateid','tag'])
             ->select();
       $res=$res->toArray();
       return $res;
    }
    //首页-查询出对应cateid的内容
    public  static  function  selectContent($cateid,$limit,array $field){
        $oneContent=self::table('article')
            ->where('cate_id','=',$cateid)
            ->order('id','desc')
            ->limit($limit)
            ->field($field)
            ->select();
        $oneContent=$oneContent->toArray();
        //查询摘要是否为空如果为空截取内容的第一句话
        for($i=0;$i<count($oneContent);$i++){
            if(empty($oneContent[$i]['abstract'])){
                $content=self::table('article')
                    ->where('id','=',$oneContent[$i]['id'])
                    ->field('content')
                    ->select();
                $content=$content->toArray();
                $contentStr=$content[0]['content'];
                $contentStr=mb_substr( $contentStr,0,mb_strpos($contentStr, '。')+1,'UTF-8');
                $oneContent[$i]['abstract'] = strip_tags($contentStr);
            }
        }
        return $oneContent;
    }
    //首页-返回最终的查询结果
    public  static  function  atLastResult($categories,$limit,$field){
        $one=self::checkCatePid($categories['cateid']);
        //判断是否具有子分类
        if(count($one)>0){
            $categories['country']=$one;
            $oneContent=self::selectContent($one[0]['cateid'],$limit,$field);
        }else{
            $oneContent=self::table('article')
                ->where('cate_id','=',$categories['cateid'])
                ->order('id','desc')
                ->limit($limit)
                ->field($field)
                ->select();
            $oneContent=$oneContent->toArray();
        }
        $categories['content']=$oneContent;
        return $categories;
    }
    //获得需要的cateid
    public  static function needCateid($limitStart,$limitLength){
        $categories=self::table('categorys')
            ->where('pid','=','0')
            ->order(['sort'=>'asc','id'=>'asc'])
            ->limit($limitStart,$limitLength)
            ->field(['id'=>'cateid','tag'])
            ->select();
        $categoryies=$categories->toArray();
        return $categoryies;
    }
    //首页-如果点击子分类返回要查找的内容
    public  static  function  clickerChild($cateid,$limit){
       return self::selectContent($cateid,$limit, ['id','image_url','author','abstract','title','create_time']);
    }
    //abstract为空用content代替
    public  static function absRep($result){
        for($i=0;$i<count($result);$i++){
            if(empty($result[$i]['abstract'])){
                $content=self::table('article')
                    ->where('id','=',$result[$i]['id'])
                    ->field('content')
                    ->select();
                $content=$content->toArray();
                $contentStr=$content[0]['content'];
                $contentStr=mb_substr( $contentStr,0,mb_strpos($contentStr, '。')+1,'UTF-8');
                $result[$i]['abstract'] = strip_tags($contentStr);
            }
    }
      return $result;
   }

    //首页左边文章
    public  static  function  indexLeftArticle(){
        //图片新闻
        $Adverstising=Adverstising::getHomeAdver();
        $Adverstising=$Adverstising->toArray();
         empty($Adverstising)?$new_pictureLimit=4:$new_pictureLimit=3;
        $new_picture=self::table("article")
            ->where("recommend","=","5")
            ->order('sort','desc')
            ->limit("$new_pictureLimit")
            ->field(['id','image_url','abstract','title',"sign"])
            ->select();
        $new_picture=$new_picture->toArray();
        $new_picture=self::absRep($new_picture);
        $new_down=self::table("article")
            ->where("recommend","=","4")
            ->order('sort','desc')
            ->limit("3")
            ->field(['id','abstract','title',"sign"])
            ->select();
        $new_down=$new_down->toArray();
        $new_down=self::absRep($new_down);
        $new_picture = array_merge($new_picture,$Adverstising,$new_down);
        $new_picture=array('Carousel'=>$new_picture);
        $categoryies=self::needCateid(0,9);
        // 第一个分类
       $resOne =self::atLastResult($categoryies[0],3,  ['id','image_url','author','abstract','title','sign','create_time']);
       //第二个分类
        $resTwo =self::atLastResult($categoryies[1],3,  ['id','image_url','author','abstract','title','sign','create_time']);
      //第三个分类
        $resthree =self::atLastResult($categoryies[2],3,  ['id','image_url','author','abstract','title','sign','create_time']);
        //第四个分类
        $resFour =self::atLastResult($categoryies[3],3,  ['id','image_url','author','abstract','title','sign','create_time']);
        // 第五个分类
        $resFive =self::atLastResult($categoryies[4],3,  ['id','image_url','author','abstract','title','sign','create_time']);
        // 第六个分类
        $resSix =self::atLastResult($categoryies[5],2,  ['id','image_url','author','abstract','title','sign','create_time']);
        // 第七个分类
        $resSeven =self::atLastResult($categoryies[6],2,  ['id','image_url','author','abstract','title','sign','create_time']);
        // 八个分类
        $resEight =self::atLastResult($categoryies[7],2,  ['id','image_url','author','abstract','title','sign','create_time']);
        // 第九个分类
        $resNine =self::atLastResult($categoryies[8],2,  ['id','image_url','author','abstract','title','sign','create_time']);
        $res = array($new_picture,$resOne,$resTwo,$resthree,$resFour,$resFive,$resSix,$resSeven,$resEight,$resNine);
       return $res;
    }
    //首页右边文章
    public  static  function  indexRightArticle(){
        $categoryies=self::needCateid(9,10);
        // 第十个分类
        $resTen =self::atLastResult($categoryies[0],6,['id','image_url','abstract','title','sign']);
        $resTen['photo']=1;   //是否为图片 当为 1的时候为图片 当为 0 的时候为list
        //第十一个分类
        $resEleven =self::atLastResult($categoryies[1],3,['id','image_url','title','sign']);
        $resEleven['photo']=1;
        //第十二个分类
        $resTwelve =self::atLastResult($categoryies[2],8,['id','image_url','title','abstract','author','sign']);
        $resTwelve['photo']=0;
        //第十三个分类
        $resThirteen =self::atLastResult($categoryies[3],2,['id','image_url','title','sign']);
        $resThirteen['photo']=1;
        //第十四个分类
        $resFourteen =self::atLastResult($categoryies[4],2,['id','image_url','title','sign']);
        $resFourteen['photo']=1;
        //第十五个分类
        $resFifteen =self::atLastResult($categoryies[5],2,['id','image_url','title','sign']);
        $resFifteen['photo']=1;
        //第十六个分类
        $resSixteen =self::atLastResult($categoryies[6],2,['id','image_url','title','abstract','author','sign']);
        $resSixteen['photo']=0;
        //第十七个分类
        $resSeventeen =self::atLastResult($categoryies[7],7,['id','image_url','title','abstract','author','sign']);
        $resSeventeen['photo']=0;
        //第十八个分类
        $resEighteen =self::atLastResult($categoryies[8],4,['id','image_url','title','abstract','author','sign']);
        $resEighteen['photo']=0;
        //第十九个分类
        $resNineteen =self::atLastResult($categoryies[9],4,['id','image_url','title','abstract','author','sign']);
        $resNineteen['photo']=0;
        $res = array($resTen,$resEleven,$resTwelve,$resThirteen,$resFourteen,$resFifteen,$resSixteen,$resSeventeen,$resEighteen,$resNineteen);
        return $res;
    }
    // list - 获得侧边栏
    public  static  function  Sidebar(){
        $categories=self::table('categorys')
            ->where('pid','=','0')
            ->order(['sort'=>'asc','id'=>'asc'])
            ->field(['id'=>'cateid','tag'])
            ->select();
        $categories=$categories->toArray();
        for ($i=0;$i<count($categories);$i++){
           $child=self::checkCatePid($categories[$i]['cateid']);
           if (count($child)>0){
               $categories[$i]['children']=$child;
           }
        }
        return $categories;
    }
    //(list)-当传输cateid的时候返回的文章list文章的列表
    public static function  articleListInt($tag,$page){
           $result1= self::table("article")
                           ->page($page,10)
                           ->order("id","desc")
                           ->where("cate_id",'=',"$tag")
                           ->field(['id','author','title','abstract','image_url','create_time','sign'])
                           ->select();
               $cate=self::table("categorys")
                         ->where("id","=","$tag")
                         ->field(["id","tag",'pid'])
                         ->find();
                $result1= $result1->toArray();
                 $result1=self::absRep($result1);
                $cate=$cate->toArray();
                 if ($cate['pid']!=0){
                     $childrenCateId = self::checkCatePid($cate['pid']);
                     $cate=self::table("categorys")
                         ->where("id","=",$cate['pid'])
                         ->field(["id","tag"])
                         ->find();
                     $cate=$cate->toArray();
                     $cate['child'] = $childrenCateId;
                 }else{
                     unset($cate['pid']);
                 }
                $adv =Adverstising::getListAdver($page);

                $result1=array_merge($result1,$adv);
                if($page==1){
                    if(count($result1)<10){
                        $cate['listContent'] = $result1;
                        $cate['ArticlNumber']="ArticleNull";
                    }else{
                        $cate['listContent'] = $result1;
                    }
                }else {
                    if (count($result1) < 10) {
                        $result['listContent'] = $result1;
                        $result['ArticlNumber'] = "ArticleNull";
                        return $result;
                    } else {
                        $result['listContent'] = $result1;
                        return $result;
                    }
                }
           return $cate;
    }
    //最热新闻
    public static function theHotNews($page){
     $result = self::table("article")
            ->page($page,6)
            ->order("pv","desc")
            ->field(['id','title'])
            ->select();
     if (count($result)<6) {
         return array($result, array("ArticlNumber" => "ArticleNull"));
     }else{
         return$result;
     }
    }
    //要问推荐页面 首页轮番图
    public static function  pushIndex(){
       //要闻推荐
        $index=self::table("article")
            ->where("recommend","=","2")
            ->order("sort","desc")
            ->limit("8")
            ->field(['id','title','image_url',"sign"])
            ->select();
        $index=$index->toArray();
        $index2=self::table("article")
            ->where("recommend","=","2")
            ->order("sort","desc")
            ->limit(9,4)
            ->field(['id','image_url','title','abstract','author','create_time',"sign"])
            ->select();
        $index2=$index2->toArray();
        $index2=self::absRep($index2);
        $Adver=Adverstising::getRecommendAdver();
        $Adver=$Adver->toArray();
        $index=array_merge($index,$Adver);
        $index=array($index,$index2);
        $index=array("首页轮播"=>$index);
        //专题推荐
        $special_topic=self::table("article")
            ->limit("3")
            ->order("sort","desc")
            ->where('recommend','=','1')
            ->field(['id','image_url','title',"sign"])
            ->select();
        $special_topic= $special_topic->toArray();
        $special_topic2=self::table("article")
            ->limit(4,4)
            ->order("sort","desc")
            ->where('recommend','=','1')
            ->field(['id','image_url','title',"sign","abstract","author","create_time"])
            ->select();
        $special_topic2= $special_topic2->toArray();
        $special_topic2=self::absRep($special_topic2);
        $special_topic=array($special_topic,$special_topic2);
        $special_topic=array("专题推荐"=>$special_topic);
        return array_merge($index,$special_topic);
    }
    //（图文）图文落地页
    public static function imageText($articleId){
        $result = self::table("article")
            ->where("id","=","$articleId")
            ->field(['id','title','image_url','abstract','content',"create_time"])
            ->select();
        $result=$result->toArray();
        $result=self::absRep($result);
        if (!empty($result)) {
            self::viewPvAdd($articleId);
        }
        return  $result;
    }

    //热门文章推荐
   public static function pushHotNews($page){

      $result= self::table("article")
           ->page($page,10)
           ->order("pv","desc")
           ->field(['id','title',"image_url","abstract"])
           ->select();
      $result=$result->toArray();
       $result=self::absRep($result);
       if (count($result)<10) {
           return array($result, array("ArticlNumber" => "ArticleNull"));
       }else{
           return $result;
       }
   }
   //精品推荐
   public static function choiceRecomm(){
    return self::moreBuotique(5);
   }
    public  static function viewPvAdd($articleId){
            $art_mysql=self::table("article")
                ->where("id","=",$articleId)
                ->field(['cate_id'])->find();
            $art_update=self::table("article")
                ->where("id","=",$articleId)
                ->setInc("pv");
            if ($art_update!=0) {
                self::table("categorys")
                    ->where("id", "=", $art_mysql['cate_id'])
                    ->setInc("view");
            }

    }
     //redis获取pv量和view的值（加1）
//    public  static function RedisViewPv($articleId){
//        $redis = Redis::getRedis();
//        $redis->select(5);
//        if(!$redis->exists("article:articleid:".$articleId.":pv"))
//        {
//            $art_mysql=self::table("article")
//                ->where("id","=",$articleId)
//                ->field(['pv','cate_id'])->find();
//            $redis->set("article:articleid:".$articleId.":pv",$art_mysql['pv']);
//            $redis->incr("article:articleid:".$articleId.":pv");
//            $redis->set("article:articleid:".$articleId.":cateid",$art_mysql['cate_id']);
//
//            if (!$redis->exists("categorys:cateid:".$art_mysql['cate_id'].":view")){
//                $cate_mysql=self::table("categorys")
//                    ->where("id","=",$art_mysql['cate_id'])
//                    ->field("view")
//                    ->find();
//                $redis->set("categorys:cateid:".$art_mysql['cate_id'].":view",$cate_mysql['view']);
//                $redis->incr("categorys:cateid:".$art_mysql['cate_id'].":view");
//            }
//        }else{
//            $redis->incr("article:articleid:".$articleId.":pv");
//            $cate_id= $redis->get("article:articleid:".$articleId.":cateid");
//            $redis->incr("categorys:cateid:".$cate_id.":view");
//        }
//    }
}