<?php

require __DIR__ . '/../vendor/autoload.php';


try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}


$app = new \App\Application(
    realpath(__DIR__ . '/../')
);

// 实例化后再加载助手函数
require __DIR__ . '/helpers.php';

return $app;