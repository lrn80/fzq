<?php
/**
 * User: xiaomin
 * Date: 2019/11/9
 * Time: 21:37
 */

namespace app\api\model;


class Arti extends BaseModel
{
    protected $table = 'article';
    public  function getImageUrlAttr($value,$date)
    {
        $finalUrl=$this->prefixImgUrl($value,$date);
        return $finalUrl;
    }

    public function getSearchArticle($content,$page){
        $start = ($page -1)*config('setting.pagesize');
        $pagesize = config('setting.pagesize');
        $field = ['id','title','abstract','author','create_time',"image_url", 'sign'];
        $order = ['id' => 'desc'];
        $whereData['title'] = [['like', '%'.$content.'%'],'or'];
        $whereData['abstract'] = ['like', '%'.$content.'%'];
        $whereStatus['is_delete'] = config('apicode.article_normal');
        $result['article'] = $this->whereor($whereData)->where($whereStatus)
                                    ->order($order)->field($field)
                                    ->limit($start,$pagesize)->select();
        $result['count'] = $this->whereor($whereData)->where($whereStatus)
            ->order($order)->field($field)->count();
        return $result;
    }

}