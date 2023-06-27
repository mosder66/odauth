易验云网络验证
===============

> 运行环境要求PHP8+，兼容PHP8.1

[云端官网](http://yiyanyun.top)


## 主要新特性

* 采用`PHP8`强类型（严格模式）
* 支持全部ThinkPHP6的特性
* 简易搭建，轻松运行

## 下载

~~~
composer create-project topthink/think tp 6.0.*
~~~

## 安装

* 上传源代码包到服务器上并解压
* 导入根目录下的Data.sql数据库文件
* 配置根目录下的.env文件【如需开启调试模式将APP_Debug=true改为false】
* 打开站点进入后台目录[下文会给出目录说明]修改默认的管理员信息
    * admin - 后台管理员目录
    * agent - 代理管理员目录
    * api   - 应用程序接口目录[【默认使用路由分配入口，请到后台查看‘API管理’】]
    * index - 前台目录



如果需要更新框架使用
~~~
composer update topthink/framework
~~~

## 文档

[开发文档](http://yun.yiyanyun.top/doc)


## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2021 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
