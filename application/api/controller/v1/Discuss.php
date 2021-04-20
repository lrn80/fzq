<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\UidNewsIDContentCheck;
use app\api\service\Token;
use app\api\service\Discuss as DiscussService;
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
}