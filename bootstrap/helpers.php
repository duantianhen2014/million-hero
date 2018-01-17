<?php

function dd($output)
{
    if (is_string($output)) {
        echo $output;
    } else {
        var_dump($output);
    }

    exit;
}


/**
 *
 */
function screenShot()
{
    $cacheFile =

    // 处理图片大小


    $image = file_get_contents($cache);

    return $image;
}

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