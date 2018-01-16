<?php

namespace App\Foundation;

use DiDom\Document;

class Answer
{
    public static function get($question)
    {
        $document = new Document('http://www.baidu.com/s?wd='.urlencode($question), true);

        // 百度搜索结果集（非百度知道）
        $posts = $document->find('.result');

        // TODO 怎么获取百度的答案结果集合
        dd($posts);
    }
}