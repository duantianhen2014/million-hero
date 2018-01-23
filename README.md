![adb环境](http://p2uena5sd.bkt.clouddn.com//million/envmillion.gif)

* gif图显示时间这么久的原因是开着录屏，电脑卡顿，硬盘读写只有 350k/s 速度
****
<p align="center">
<a href="https://packagist.org/packages/davidnineroc/million-hreo"><img src="https://travis-ci.org/DavidNineRoc/million-hero.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/117396091"><img src="https://styleci.io/repos/117396091/shield?branch=master" alt="StyleCI"></a>
</p> 

## Usage
1. 环境要求
   * PHP >= 7.0 [phpstudy集成环境](http://www.phpstudy.net/)
   * composer [下载地址](http://www.phpcomposer.com/)
   * ADB 驱动 [下载地址](https://adb.clockworkmod.com/)
   * 以上请配置好环境变量 [配置方法](http://blog.shiguopeng.cn/article/10201.html)
2. 使用`composer`安装
```shell
composer create-project davidnineroc/million-hero
```
3. 按需配置`/config/*`下文件
4. 在根目录执行
    * 连接手机 (或者运行模拟器)
    * 测试运行环境(如果通过就可以正常使用了)
    * `php test`
    * /config/app.php > model 有高速和兼容两个模式选择
    * 运行项目
    * `php artisan`
## Errors
* `/system/bin/sh: can't create xxx: Read-only file system`
    * 目录权限不足，请把项目放到其他盘，一般在桌面都失败
## Help
* 执行`php test`有可能出现的情况
* adb 环境目录未添加
    * [下载地址adb](https://adb.clockworkmod.com/)
    * [添加环境目录](http://blog.shiguopeng.cn/article/10201.html)
    ![adb环境](http://p2uena5sd.bkt.clouddn.com//million/env1.png)
* 手机未连接
    * 手机拔出USB重新连接,开启调试模式
    * 模拟器的话重启
    
![adb环境](http://p2uena5sd.bkt.clouddn.com//million/envenv2.png)
* 成功
    ![adb环境](http://p2uena5sd.bkt.clouddn.com//million/env3.png)
* `php artisan`如果执行失败，请[Issure](https://github.com/DavidNineRoc/million-hero/issues)   
  ![adb环境](http://p2uena5sd.bkt.clouddn.com//million/env4.png)
## Reference
* [wangtonghe/hq-answer-assist](https://github.com/wangtonghe/hq-answer-assist)
## TODO
* 网络优化请求接口，截图功能耗时
* `adb shell screencap -p > screenshot.png` 截图出来的图片总是错误
* 不要io读写，直接`adb shell screencap -p`获取二进制数据，请求百度接口
* 优化配置读取
* 优化程序代码
* 自动截图    
## License
MIT