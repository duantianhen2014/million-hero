<?php

namespace App\Foundation;


use DiDom\Document;

class Request
{
    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function getAnswer($question)
    {
        $this->document->loadHtmlFile('http://www.baidu.com/s?wd='.urlencode($question));

        $text = $this->document->find('.c-container')[0]->text();
        $text .= $this->document->find('.c-container')[1]->text();
        $text .= $this->document->find('.c-container')[2]->text();
        $text = preg_replace('/\s*/', '', $text);
        return $text;
    }

    /**
     * 获取相关词条数目
     */
    function getResultCount($question, $answers)
    {
        $results = [];
        foreach ($answers as $key => $answer) {
            // 获取结果集合
            $this->document->loadHtmlFile('http://www.baidu.com/s?wd='.urlencode($question . ' ' . $answer));

            $posts = $this->document->find('.nums');

            // 每个问题+选项的搜索结果数量
            $results[] = (int)$this->getCount($posts[0]->text());
        }

        return $results;
    }

    protected function getCount($text)
    {
        $text = str_replace(',', '', $text);
        $count = trim($text,'搜索工具百度为您找到相关结果约,个');
        return $count;
    }
}