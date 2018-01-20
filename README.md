



## Usage
1. 使用`composer`安装
```shell
composer require davidnineroc/qrcodeplus
```
2. 按需配置`/config/*`下文件
3. 在根目录执行
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