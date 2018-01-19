<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Pool;
$app = require __DIR__ . '/bootstrap/app.php';

// 使用异步请求
$app->run();
