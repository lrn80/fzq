<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\NewsIdCheck;
use app\api\validate\UidNewsIDContentCheck;
use app\api\service\Token;
use app\api\service\Discuss as DiscussService;
use app\exception\DiscussException;
use app\exception\NewException;
use app\exception\SucceedMessage;

class Discuss extends BaseController
{
    /**
     * 添加评论
     */
    public function discuss() {
        (new UidNewsIDContentCheck())->goCheck();
        $uid = Token::getCurrentTokenVar('id');
        $params = $this->request->param();
        $news_id = $params['news_id'] ?? '';
        $content = $params['content'] ?? '';
        $res = DiscussService::addDiscuss($uid, $news_id, $content);
        if ($res) {
            throw new SucceedMessage();
        } else {
            throw new NewException();
        }
    }

    /**
     * 评论点赞
     * @throws DiscussException
     * @throws SucceedMessage
     * @throws \app\exception\ParamException
     * @throws \app\exception\TokenException
     * @throws \think\Exception
     */
    public function discussUpvote() {
        (new NewsIdCheck())->goCheck();
        $uid = Token::getCurrentTokenVar('id');
        $params = $this->request->param();
        $news_id = $params['news_id'] ?? '';
        $discuss_id = $params['discuss_id'] ?? '';
        $res = DiscussService::discussUpvote($discuss_id, $news_id);
        if ($res) {
            throw new SucceedMessage();
        } else {
            throw new DiscussException();
        }
    }

    public function discussUpvoteDel() {
        (new NewsIdCheck())->goCheck();
        $uid = Token::getCurrentTokenVar('id');
        $params = $this->request->param();
        $news_id = $params['news_id'] ?? '';
        $discuss_id = $params['discuss_id'] ?? '';
        $res = DiscussService::discussUpvoteDel($discuss_id, $news_id);
        if ($res) {
            throw new SucceedMessage();
        } else {
            throw new DiscussException();
        }
    }
}