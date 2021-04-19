<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token;
use app\api\service\SearchHistory as SearchHistoryService;
class SearchHistory extends BaseController
{
    /**
     * 获取搜索历史列表
     * @return \think\response\Json
     * @throws \app\exception\TokenException
     * @throws \think\Exception
     */
    public function getSearchHistory()
    {
        $uid = Token::getCurrentTokenVar('id');
        return json(SearchHistoryService::getSearchHistoryList($uid));
    }


}