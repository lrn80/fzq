<?php


namespace app\api\common;


class CommConst
{
    // 用户点赞类型
    const UPVOTE_NEWS = 1; //文章点赞
    const UPVOTE_DISCUSS = 2; //评论点赞

    // 关注粉丝
    const RELATION_FOLLOW = 1; //关注
    const RELATION_FANS = 2; // 粉丝

    //
    const FOLLOW_STATUS_ALREADY = 1;// 关注过
    const FOLLOW_STATUS_NOT = 0; //没有关注过

    const COLLECT_STATUS_ALREADY = 1;// 关注过
    const COLLECT_STATUS_NOT = 0; //没有关注过

    const UPVOTE_STATUS_ALREADY = 1;// 关注过
    const UPVOTE_STATUS_NOT = 0; //没有关注过
}