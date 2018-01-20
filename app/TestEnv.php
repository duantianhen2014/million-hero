<?php

namespace App;

use App\Foundation\ScreenShot;

trait TestEnv
{
    protected $testStatus = [];

    public function testAdbDriverEnv()
    {
        $shell = 'adb version';
        exec($shell, $output, $code);

        $status = 'SUCCESS';
        // 没有配置环境目录
        if (0 !== $code) {
            $status = '环境目录未生效';
        }

        $this->testStatus[] = [$shell, 'ADB 驱动检测', $status];

        return $this;
    }

    public function testAdbConnectEnv()
    {
        $shell = 'adb devices';
        exec($shell, $output, $code);

        $status = 'SUCCESS';
        // 判断输出 第一个是 List of devices attached  最后一个是空字符串
        array_shift($output);
        array_pop($output);

        if (empty($output)) {
            $status = '未检测到手机连接';
        } else {
            $device = current($output);
            if (!strstr($device, 'device')) {
                $status = '请重新连接手机';
            }
        }

        $this->testStatus[] = [$shell, '手机连接状态检测', $status];

        return $this;
    }

    public function testAdbScreenEnv()
    {
        $tmp = $this->make('config')->get('cache.tmp');
        $file = __DIR__.'/../bootstrap/cache/tests/'.time().'.png';

        (new ScreenShot(
            $tmp,
            $file)
        )->capture();

        // 文件是否存在
        if (is_file($file)) {
            $status = 'SUCCESS';
        } else {
            $status = '截图功能错误';
        }

        $this->testStatus[] = ['adb shell screencap', '截图功能检测', $status];

        return $this;
    }

    public function getTestStatus()
    {
        $testStatus = [];
        foreach ($this->testStatus as $status) {
            $testStatus[] = [
                'shell' => $status[0],
                '功能' => $status[1],
                '状态' => $status[2],
            ];
        }

        return $testStatus;
    }
}
