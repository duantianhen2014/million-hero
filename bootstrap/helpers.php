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

function getTableText($array)
{
    $max = 0;
    $parameters = [];
    $text = "+%s+\n";

    foreach ($array as $value) {
        $text .= "|%s|\n";
        $parameters[] = $value;
        if ($max < strlen($value)) {
            $max = strlen($value);
        }

    }

    array_unshift($parameters, str_repeat('-', $max));
    // 替换最大宽度
    $text = str_replace('%s', "%-{$max}s", $text);

    // 正则替换
    return sprintf($text, ...$parameters);
}


function getAnswer($word, $ans)
{
    getResultCount($word, ['a' => '滕王阁', 'b' => '施国鹏', 'c' =>'大一']);

exit;
}

function getResultCount($word, $answers)
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
            'http://www.baidu.com/s?wd='.urlencode($word . ' ' . $answer)
            , true
        );
        $posts = $document->find('.nums');
        foreach($posts as $post) {
            // 每个问题+选项的搜索结果数量
            $results[$key] = (int)$getCount($post->text());
        }
    }

    return $results;
}
