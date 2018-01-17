<?php

define('ROOT_PATH', __DIR__);

// 加载助手函数
require ROOT_PATH . '/bootstrap/helpers.php';

// 截图
// $file = screenShot();
$file = config('cache.file');
// 调整图片大小
resizeImage($file);

// 请求百度文字识别接口
$text = requestAipOcr(file_get_contents($file));

var_dump($text);