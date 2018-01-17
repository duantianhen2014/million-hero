<?php

    define('ROOT_PATH', __DIR__);

    // 随时使用 config
    $_CONFIG = function($key) {
        static $instance;

        if (is_null($instance)) {
            $instance['aip'] = require ROOT_PATH . '/config/aip.php';
            $instance['cache'] = require ROOT_PATH . '/config/cache.php';
        }

        list($file, $key) = explode('.', $key);
        return $instance[$file][$key];
    };

    require ROOT_PATH . '/bootstrap/helpers.php';

    // 截图
    $image = ScreenShot::getScreenShot();

    // 请求百度文字识别接口
    list($question, $a, $b, $c) = ReadImage::getText($image);

    // 把问题拿去寻求百度
    Answer::get($question);