<?php

namespace App\Foundation;


use AipOcr;

class Api
{
    protected $client;
    public function __construct(AipOcr $aipOcr)
    {
        $this->client = $aipOcr;
    }

    public function requestText($image)
    {
        $response = $this->client->basicGeneral($image);

        $words_result = $this->unsetArrKey($response['words_result']);

        // 去最后三个答案
        $c = array_pop($words_result);
        $b = array_pop($words_result);
        $a = array_pop($words_result);

        // 去最后一个
        $questions = implode(',', $words_result);
        $questions = trim($questions, '?？');

        return [$questions, $a, $b, $c];
    }

    /**
     * 抓换二维数组成为以为索引数组
     */
     protected function unsetArrKey($words_result, $realKey = 'words')
     {
         foreach ($words_result as $key => $word) {
             $words_result[$key] = $word[$realKey];
         }

         return $words_result;
     }
}