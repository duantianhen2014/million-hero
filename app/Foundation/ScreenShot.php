<?php

namespace App\Foundation;


class ScreenShot
{
    public function capture()
    {
        $tmp = config('cache.tmp');
        $cache = config('cache.file');

        // 直接获取输出
        shell_exec("adb shell screencap -p {$tmp}");
        shell_exec("adb pull {$tmp} {$cache}");

        return $cache;
    }
}