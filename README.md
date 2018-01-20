<p align="center">
<a href="https://packagist.org/packages/davidnineroc/million-hreo"><img src="https://travis-ci.org/DavidNineRoc/million-hero.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/117396091"><img src="https://styleci.io/repos/117396091/shield?branch=master" alt="StyleCI"></a>
<a href="https://packagist.org/packages/davidnineroc/million-hero"><img src="https://poser.pugx.org/davidnineroc/million-hero/downloads" alt="Downloads"></a>
<a href="https://packagist.org/packages/davidnineroc/million-hero"><img src="https://poser.pugx.org/davidnineroc/million-hero/license" alt="License"></a>
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
    * 运行项目
    * `php artisan`
## Errors
* /system/bin/sh: can't create xxx: Read-only file system
    * 目录权限不足，请把项目放到其他盘，一般在桌面都失败
## TODO
* 使用异步请求
* 自动截图    
## License
MIT