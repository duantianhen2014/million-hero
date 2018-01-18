<?php

define('ROOT_PATH', __DIR__);
define('START_TIME', microtime(true));
// 加载助手函数
require ROOT_PATH . '/vendor/autoload.php';
require ROOT_PATH . '/bootstrap/helpers.php';

// 截图
$file = screenShot();
// 调整图片大小
resizeImage($file);

// 请求百度文字识别接口
list($question, $a, $b, $c) = requestAipOcr(file_get_contents($file));

// 获取结果集合
list($aCount, $bCount, $cCount) = getResultCount($question, compact('a', 'b', 'c'));

// 输出结果集
$table = new LucidFrame\Console\ConsoleTable();
$table->setHeaders(['问题', $question])
    ->addRow(['答案', '关联数'])
    ->addBorderLine()
    ->addRow([$a, $aCount])
    ->addRow([$b, $bCount])
    ->addRow([$c, $cCount])
    ->setPadding(5)
    ->display();


// 获取百度结果
echo getAnswer($question);

var_dump(microtime(true)-START_TIME);


