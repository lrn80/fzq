<?php
/**
 * User: ruoning
 * Date: 2021/3/14
 * motto: 知行合一!
 */
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\TokenUser;
use app\api\validate\NewsIdCheck;
use app\api\validate\SearchCheck;
use app\api\validate\NewsPageCheck;
use app\api\service\News as NewsService;
use app\exception\NewException;
use think\Log;
use app\api\service\Token;
class News extends BaseController
{
    /**
     * 获取文章列表
     * @return \think\response\Json
     * @throws NewException
     * @throws \app\exception\ParamException
     * @throws \think\Exception
     */
    public function getNewsList()
    {
        (new NewsPageCheck())->goCheck();
        $params = request()->param();
        try {
            $new_list = NewsService::getNewsList($params);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . "get news list exception error: " . $e->getMessage());
            throw new NewException();
        }

        return json($new_list);
    }

    /**
     * 获取文章详情
     * @return \think\response\Json
     * @throws NewException
     * @throws \app\exception\ParamException
     * @throws \think\Exception
     */
    public function getNewsInfo()
    {
        (new NewsIdCheck())->goCheck();
        $params = request()->param();
        $uid = Token::getCurrentTokenVar('id');
        $res = NewsService::getNewsInfo($params, $uid);
        if (!$res) {
            throw new NewException([
                'msg' => '你查询的文章不存在或者已删除'
            ]);
        }

        return json($res);
    }

    /**
     * 点赞
     * @return \think\response\Json
     * @throws NewException
     * @throws \app\exception\ParamException
     * @throws \think\Exception
     */
    public function upvote()
    {
        (new NewsIdCheck())->goCheck();
        $news_id = $this->request->param('news_id');
        $uid = Token::getCurrentTokenVar('id');
        $res = NewsService::upvote($uid, $news_id);
        if (!$res) {
            throw new NewException([
                'msg' => '文章已删除或者不存在'
            ]);
        }

        return json($res);
    }

    /**
     * 取消点赞
     */
    public function delUpvote()
    {
        (new NewsIdCheck())->goCheck();
        $news_id = $this->request->param('news_id');
        $uid = Token::getCurrentTokenVar('id');
        $res = NewsService::delUpvote($uid, $news_id);
        if (!$res) {
            throw new NewException([
                'msg' => '文章已删除或者不存在'
            ]);
        }

        return json($res);
    }

    /**
     * 文章搜索
     */
    public function search() {
        (new SearchCheck())->goCheck();
        $params = $this->request->get();
        $params['uid'] = Token::getCurrentTokenVar('id');
        $news_list = NewsService::search($params);
        return json($news_list);
    }

    /**
     * 获取当前用户的文章列表
     * @throws \app\exception\TokenException
     * @throws \think\Exception
     */
    public function  getUserNewsList() {
        (new NewsPageCheck())->goCheck();
        $uid = Token::getCurrentTokenVar('id');
        $page = $this->request->param('page');
        $list = NewsService::getUserNewsList($uid, $page);
        return json($list);
    }
}