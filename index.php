<?php

define('ROOT_PATH', __DIR__);

// 加载助手函数
require ROOT_PATH . '/vendor/autoload.php';
require ROOT_PATH . '/bootstrap/helpers.php';

// 截图
// $file = screenShot();
$file = config('cache.file');
// 调整图片大小
resizeImage($file);

// 请求百度文字识别接口
list($question, $a, $b, $c) = requestAipOcr(file_get_contents($file));

// 获取结果集合
list($aCount, $bCount, $cCount) = getResultCount($question, compact('a', 'b', 'c'));

// 输出题目和答案
echo getTableText([" 题目: {$question}", " A: {$a}", " B: {$b}", " C: {$c}"]);


