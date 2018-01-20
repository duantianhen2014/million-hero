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

    public function getAnswer($question, $count)
    {
        $this->document->loadHtmlFile('http://www.baidu.com/s?wd='.urlencode($question));

        $text = '';
        // 比较权威一点的答案
        if ($this->document->has('#content_left .result-op')) {
            // 0 ==> 右边的相关 1 == > 权威
            $text .= "\n*********  权威   ***********\n";
            $text .= $this->document->find('#content_left .result-op')[0]->text();
            $text .= "\n\n";
        }

        // 这个可选配置
        for ($i = 0; $i < $count; ++$i) {
            $container = $this->document->find('.c-container')[$i];

            if (!$container) {
                break;
            }
            $text .= $container->text();
        }

        $text = preg_replace('/\s*/', '', $text);

        return $text;
    }

    /**
     * 获取相关词条数目.
     */
    public function getResultCount($question, $answers)
    {
        $results = [];
        foreach ($answers as $key => $answer) {
            // 获取结果集合
            $this->document->loadHtmlFile('http://www.baidu.com/s?wd='.urlencode($question.' '.$answer));

            $posts = $this->document->find('.nums');

            // 每个问题+选项的搜索结果数量
            $results[] = intval($this->getCount($posts[0]->text()));
        }

        return $results;
    }

    protected function getCount($text)
    {
        $text = str_replace(',', '', $text);
        $count = trim($text, '搜索工具百度为您找到相关结果约,个');

        return $count;
    }
}
