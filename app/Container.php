<?php

namespace App;


use AipOcr;

class Container
{
    public static $instance;

    protected $basePath;
    protected $aipOcr;
    protected $config;


    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    protected function registerServices()
    {
        static::$instance = $this;
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


    public function getBasePath()
    {
        return $this->basePath;
    }
}