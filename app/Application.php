<?php

namespace App;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class Application extends Container
{
    protected $startTime;

    public function __construct($startTime)
    {
        $this->startTime = $startTime;
    }

    public function run()
    {
        // 截图
        $file = $this->make('screen')->capture();
        // 调整图片大小
        $this->make('image')->cut($file)->save();

        // 请求百度文字识别接口
        list(
            $question,
            $a,
            $b,
            $c
        ) = $this->make('api')->requestText(file_get_contents($file));


        // 发送异步请求
        $requests = function ($url) {

            foreach ($url as $uri) {
                yield new Request('GET', $uri);
            }
        };
        $pool = new Pool(
            $this->make('client'),
            $requests([
                'a'   => 'http://www.baidu.com/s?wd='.urlencode($question . ' ' . $a),
                'b'   => 'http://www.baidu.com/s?wd='.urlencode($question . ' ' . $b),
                'c'   => 'http://www.baidu.com/s?wd='.urlencode($question . ' ' . $c),
                'detail' => 'http://www.baidu.com/s?wd='.urlencode($question),
            ]),
            [
            'concurrency' => 1,
            'fulfilled' => function ($response, $index) {
                $parse = $this->make('parse');
                $parse->load($response->getBody()->getContents());
                var_dump($parse->find('.nums')[0]->getPlainText());
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();

        exit;
        var_dump(111);
        sleep(10);
        // 异步获取结果集
        list(
            $aCount,
            $bCount,
            $cCount
        ) = $this->make('request')->getResultCount(
                $question, compact('a', 'b', 'c')
            );

        // 输出结果集
        $table = $this->make('table');
        $table->addRows([
            [
                'option' => '问题',
                'answer' => $question
            ],
            [
                'option' => $a,
                'answer' => $aCount
            ],
            [
                'option' => $b,
                'answer' => $bCount
            ],
            [
                'option' => $c,
                'answer' => $cCount
            ],
        ]);
        echo $table->renderTable();


        // 获取百度结果
        $answer = $this->make('request')->getAnswer($question);
        echo "\n" . splitZh($answer, 20, "\n");

        $this->runTime();
    }

    public function runTime()
    {
        // 输出
        echo "运行时间: " . (microtime(true) - $this->startTime) . "\n";
        return true;
    }
}