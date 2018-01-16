<?php

namespace App\Foundation;


class Image
{
    public static function resize($file, $width = 520)
    {
        $cache = cachePath(env('CACHE_FILE'));

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
        imagepng($dst, $cache);
        imagedestroy($dst);
    }
}