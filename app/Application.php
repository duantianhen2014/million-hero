<?php

namespace App;

use AipOcr;
use App\Foundation\Command;

class Application
{
    protected $basePath;
    protected $aipOcr;
    protected $config;

    public function __construct($basePath = '')
    {
        $this->basePath = $basePath;

        $this->registerConfig();
        $this->registerAipOcr();
    }

    public function run()
    {
        // 截图
        $image = $this->getBase64ScreenShot();

        // 请求百度文字识别接口
        $results = $this->aipOcr->basicGeneral($image, $this->config);

        var_dump($results);
    }

    protected function registerAipOcr()
    {
        require $this->basePath . '/app/Support/AipOcr.php';

        $app_id = env('APP_ID', '');
        $api_key = env('API_KEY', '');
        $secret_key = env('SECRET_KEY', '');

        $this->aipOcr = new AipOcr($app_id, $api_key, $secret_key);
    }

    protected function registerConfig()
    {
        $this->config = [
            'language_type' => env('LANGUAGE_TYPE', 'CHN_ENG'),
            'detect_direction' => env('DETECT_DIRECTION', 'false'),
            'detect_language' => env('DETECT_LANGUAGE', 'false'),
            'probability' => env('PROBABILITY', 'false'),
        ];
    }


    protected function getBase64ScreenShot()
    {
        $output = $this->getScreenShot();

        file_put_contents('1.png', $output);

        return base64_encode($output);
    }

    protected function getScreenShot()
    {
        // 直接获取输出
        $output = Command::shellExec('adb shell screencap -p');

        // here, 在PHP运行就不行，直接通过环境就可以
        return $output;
    }
}