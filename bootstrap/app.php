<?php

require __DIR__ . '/../vendor/autoload.php';


try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {

}

require __DIR__ . '/helpers.php';

$app = new \App\Application(
    realpath(__DIR__ . '/../')
);


return $app;