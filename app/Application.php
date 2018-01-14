<?php

namespace App;


use AipOcr;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\Output;

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
        $this->screenShot();
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

    protected function screenShot()
    {

    }
}