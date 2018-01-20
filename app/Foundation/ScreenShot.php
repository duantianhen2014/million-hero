<?php

namespace App\Foundation;

class ScreenShot
{
    protected $tmpFile;

    protected $cacheFile;

    public function __construct($tmpFile, $cacheFile)
    {
        $this->tmpFile = $tmpFile;
        $this->cacheFile = $cacheFile;
    }

    public function capture()
    {
        // 直接获取输出
        shell_exec("adb shell screencap -p {$this->tmpFile}");
        shell_exec("adb pull {$this->tmpFile} {$this->cacheFile}");

        return $this->cacheFile;
    }
}
