<?php

// 随时使用 config
function config($key) {
    static $instance;

    if (is_null($instance)) {
        $instance['aip'] = require ROOT_PATH . '/config/aip.php';
        $instance['cache'] = require ROOT_PATH . '/config/cache.php';
    }

    list($file, $key) = explode('.', $key);
    return $instance[$file][$key];
};

// 打印
function dd($output)
{
    if (is_string($output)) {
        echo $output;
    } else {
        var_dump($output);
    }

    exit;
}


// 调用 adb 截屏
function screenShot()
{
    $tmp = config('cache.tmp');
    $cache = config('cache.file');

    // 直接获取输出
    shell_exec("adb shell screencap -p {$tmp}");
    shell_exec("adb pull {$tmp} {$cache}");

    return $cache;
}

// 缩小图片，防止图片太大不好传输
function resizeImage($file, $width = 520)
{
    $handle = imagecreatefrompng($file);

    $x = imagesx($handle);
    $y = imagesy($handle);

    $height = $y/$x*$width;
    $dst = imagecreatetruecolor($width, $height);
    // 百万英雄，截图大小 70, 300, $w-100,900
    if ($y > 900) {
        $y = 900;
    }

    imagecopyresized($dst, $handle, 0, 0, 70, 300, $width, $height, $x-100, $y);

    imagedestroy($handle);
    imagepng($dst, $file);
    imagedestroy($dst);
}


function requestAipOcr($image)
{
    static $instance;

    if (is_null($instance)) {
        require ROOT_PATH . '/app/Support/AipOcr.php';
        $instance = new AipOcr(config('aip.APP_ID'), config('aip.API_KEY'), config('aip.SECRET_KEY'));
    }

    $response = $instance->basicGeneral($image);

    $words_result = unsetArrKey($response['words_result']);

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
function unsetArrKey($words_result, $realKey = 'words')
{
    foreach ($words_result as $key => $word) {
        $words_result[$key] = $word[$realKey];
    }

    return $words_result;
}

function getTableText($question, $answers)
{
    $max = strlen($question);
    // 头部
    $text = "+%s+\n";
    // 放入问题
    $text .= "|%s|\n";
    $parameters[] = $question;

    // 放入答案
    foreach ($answers as $answer) {
        // 第一个是答案，第二个是匹配的结果数
        $text .= "|%s|\n";
        $parameters[] = $answer;
        // 获取最大字符数
        if ($max < strlen($answer)) {
            $max = strlen($answer);
        }

    }

    array_unshift($parameters, str_repeat('-', $max));
    // 替换最大宽度
    $text = str_replace('%s', "%s", $text);

    // 正则替换
    return sprintf($text, ...$parameters);
}


function getAnswer($question)
{
    $document = new DiDom\Document('http://www.baidu.com/s?wd='.urlencode($question), true);

    $text = $document->find('.c-container')[0]->text();
    $text = preg_replace('/\s*/', '', $text);
    return $text;
}

function getResultCount($question, $answers)
{
    $getCount = function($text) {
        $text = str_replace(',', '', $text);
        $count = trim($text,'搜索工具百度为您找到相关结果约,个');
        return $count;
    };


    $results = [];
    foreach ($answers as $key => $answer) {
        // 获取结果集合
        $document = new DiDom\Document(
            'http://www.baidu.com/s?wd='.urlencode($question . ' ' . $answer)
            , true
        );
        $posts = $document->find('.nums');
        // 每个问题+选项的搜索结果数量
        $results[] = (int)$getCount($posts[0]->text());
    }

    return $results;
}
