<?php

namespace App;


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

        // 获取结果集合
        list(
            $aCount,
            $bCount,
            $cCount
        ) = $this->make('request')->getResultCount(
                $question, compact('a', 'b', 'c')
            );

        // 输出结果集
        $this->make('table')->setHeaders(['问题', $question])
            ->addRow(['答案', '关联数'])
            ->addBorderLine()
            ->addRow([$a, $aCount])
            ->addRow([$b, $bCount])
            ->addRow([$c, $cCount])
            ->setPadding(5)
            ->display();


        // 获取百度结果
        echo $this->make('request')->getAnswer($question);
        $this->runTime();
    }

    public function runTime()
    {
        // 输出
        echo "运行时间: " . (microtime(true) - $this->startTime) . "\n";
        return true;
    }
}