<?php

namespace App\Foundation;

use App\Application;

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
        if (Application::getInstance()->make('config')->get('app.model') == 'high') {
            $this->highSpeedCapture();
        } else {
            $this->compatibleCapture();
        }

        return $this->cacheFile;
    }

    /**
     * 兼容模式截图
     */
    public function compatibleCapture()
    {
        // 直接获取输出
        shell_exec("adb shell screencap -p {$this->tmpFile}");
        shell_exec("adb pull {$this->tmpFile} {$this->cacheFile}");

        return $this->cacheFile;
    }

    /**
     * 高速模式截图
     */
    public function highSpeedCapture()
    {
        // 直接获取输出
        shell_exec("adb shell screencap -p {$this->cacheFile}");

        return $this->cacheFile;
    }
}
