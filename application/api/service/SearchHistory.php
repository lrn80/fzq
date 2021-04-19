<?php


namespace app\api\service;
use \app\api\model\SearchHistory as SearchHistoryModel;

class SearchHistory
{
    public static function getSearchHistoryList($uid)
    {
        $search_history_model = new SearchHistoryModel();
        return $search_history_model->getByUid($uid);
    }
}