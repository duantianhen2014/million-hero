<?php

namespace App;

use AipOcr;
use App\Foundation\Answer;
use App\Foundation\Command;
use App\Foundation\ReadImage;
use App\Foundation\ScreenShot;

class Application extends Container
{


    public function __construct($basePath = '')
    {
        $this->basePath = $basePath;

        $this->registerServices();
    }

    public function run()
    {
        // 截图
        $image = ScreenShot::getScreenShot();

        // 请求百度文字识别接口
        list($question, $a, $b, $c) = ReadImage::getText($image);

        // 把问题拿去寻求百度
        Answer::get($question);
    }






}