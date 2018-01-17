<?php

namespace App\Foundation;


use AipOcr;
use App\Application;
use Exception;

class ReadImage
{
    protected static $instance;
    protected static $config;
    protected static $client;



    public static function getText($image)
    {
        $client = self::getAipOcr();
        $config = self::getConfig();

        $response = $client->basicGeneral($image, $config);

        if (! isset($response['words_result'])) {
            dd($response);
            throw new Exception('百度接口返回错误');
        }

        $text = self::getFormatText($response['words_result']);

        return $text;
    }

    protected static function getAipOcr()
    {
        if (is_null(self::$client)) {
            $basePath = Application::getInstance()->getBasePath();

            require $basePath . '/app/Support/AipOcr.php';

            $app_id = env('APP_ID', '');
            $api_key = env('API_KEY', '');
            $secret_key = env('SECRET_KEY', '');

            self::$client = new AipOcr($app_id, $api_key, $secret_key);
        }

        return self::$client;
    }



    protected static function getFormatText($words_result)
    {
        $words_result = self::unsetArrKey($words_result);

        // 去最后三个答案
        $c = array_pop($words_result);
        $b = array_pop($words_result);
        $a = array_pop($words_result);

        // 去最后一个
        $questions = implode(',', $words_result);
        $questions = trim($questions, '?？');

        return [$questions, $a, $b, $c];
    }

    protected static function unsetArrKey($words_result)
    {
        foreach ($words_result as $key => $word) {
            $words_result[$key] = $word['words'];
        }

        return $words_result;
    }
}