<?php

namespace App\Foundation;


class ScreenShot
{
    public static function getScreenShot()
    {
        $cache = self::screenShot();

        // 处理图片大小
        Image::resize($cache);

        $image = file_get_contents($cache);

        return $image;
    }

    protected static function screenShot()
    {
        $tmp = env('TMP_FILE');
        $cache = cachePath(env('CACHE_FILE'));

        // 直接获取输出
        // Command::shellExec("adb shell screencap -p {$tmp}");
        // Command::shellExec("adb pull {$tmp} {$cache}");

        return $cache;
    }
}