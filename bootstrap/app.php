<?php

require ROOT_PATH . '/vendor/autoload.php';


$app = new \App\Application;

$app->bind('table', LucidFrameTest\Console\ConsoleTable::class);



return $app;