<?php

require __DIR__ . '/../vendor/autoload.php';


$app = new \App\Application(
    microtime(true)
);



// 图片处理
$app->bind('image', \App\Foundation\Image::class);
// 表格输出
$app->bind('table', \AsciiTable\Builder::class);
// 配置
$app->bind('config', function(){
    return new \App\Foundation\Config(__DIR__ . '/../config');
});
// 截图
$app->bind('screen', function() use ($app){
    return new \App\Foundation\ScreenShot(
        $app->make('config')->get('cache.tmp'),
        $app->make('config')->get('cache.file')
    );
});
// 百度 Aip
$app->bind('api', function() use ($app){
    require __DIR__ . '/../app/Support/AipOcr.php';

    return new \App\Foundation\Api(
        new AipOcr(
            $app->make('config')->get('aip.APP_ID'),
            $app->make('config')->get('aip.API_KEY'),
            $app->make('config')->get('aip.SECRET_KEY')
        )
    );
});
// 爬取答案
$app->bind('request', function(){
    return new \App\Foundation\Request(
        new \DiDom\Document()
    );
});



return $app;