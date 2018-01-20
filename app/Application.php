<?php

namespace App;

class Application extends Container
{
    use TestEnv;

    protected $startTime;

    public function __construct($startTime = 0)
    {
        $this->startTime = $startTime;
        $this->register();
    }

    public function run()
    {
        // 截图               !!! TODO 这里平均花费 2.5s~3s 时间，换个方法截图，
        $file = $this->make('screen')->capture();

        // 调整图片大小        !!! 平均花费 0.2s 左右
        $this->make('image')->cut($file)->save();

        // 请求百度文字识别接口 !!! 平均花费 1s 视情况而定
        list(
            $question,
            $a,
            $b,
            $c
        ) = $this->make('aip')->requestText(file_get_contents($this->make('config')->get('cache.file')));



        // 获取相关结果集合     !!! 请求三次得到结果集合 花费 2.5 左右，待优化，并发处理
        list(
            $aCount,
            $bCount,
            $cCount
        ) = $this->make('request')->getResultCount(
                $question, [$a, $b, $c]
            );

        // 输出结果集
        $table = $this->make('table');
        $table->addRows([
            [
                'option' => '问题',
                'answer' => $question,
            ],
            [
                'option' => $a,
                'answer' => $aCount,
            ],
            [
                'option' => $b,
                'answer' => $bCount,
            ],
            [
                'option' => $c,
                'answer' => $cCount,
            ],
        ]);
        response($table->renderTable());

        // 获取相关结果   !!! 1.2s 左右
        $answer = $this->make('request')->getAnswer($question, $this->make('config')->get('app.result_count'));
        responseLine(splitZh($answer, 20, "\n"));

        $this->runTime();
    }

    public function runTime()
    {
        // 输出
        echo '运行时间: '.(microtime(true) - $this->startTime)."\n";

        return true;
    }

    protected function register()
    {
        static::$instance = $this;
    }
}
