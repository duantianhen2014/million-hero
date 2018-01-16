<?php

namespace App;

use AipOcr;
use App\Foundation\Command;

class Application extends Container
{


    public function __construct($basePath = '')
    {
        $this->basePath = $basePath;

        $this->registerServices();
        $this->registerConfig();
        $this->registerAipOcr();
    }

    public function run()
    {
        // 截图
        $this->screenShot();

        exit;
        // 请求百度文字识别接口
        $results = $this->aipOcr->basicGeneral($image, $this->config);

        var_dump($results);
    }



    protected function screenShot()
    {
        $tmp = env('TMP_FILE');
        $cache = cachePath(env('CACHE_FILE'));

        // 直接获取输出
        Command::shellExec("adb shell screencap -p {$tmp}");
        Command::shellExec("adb pull {$tmp} {$cache}");
    }


}