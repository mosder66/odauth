<?php
/*
 * @Author: Lucifer
 * @Date: 2022-03-13 17:10:00
 * @LastEditTime : 2022-07-02 11:35:37
 * @FilePath     : \yiyanyun\config\web.php
 */

/**
 * 备注是从上往下备注
 * 请注意链接后面是否存在有英文斜杠即[/]如默认有需务必添加上
 */

return [
    //当前版本
    'version' => '1',
    //云端接口[大佬请放过，机器提供不了您快乐]
    'yun_api' => '本版本暂不提供绑定',
    // SMTP服务器地址
    'smtp_host' => 'smtp.126.com',
    // 邮件用户
    'smtp_user' => 'xxxxx@126.com',
    // 邮件密码
    'smtp_pass' => 'xxxxxx',
    // 邮件端口
    'smtp_port' => '25',
    // 返回地址（支付）
    'notify_url' => 'http://localhost/',
    // 返回地址（支付）
    'return_url' => 'http://localhost/user/balance/notify',
    // 支付ID
    'pay_id' => '1001',
    // 支付Key
    'pay_key' => '123456',
    // 支付API
    // 'pay_url' => 'http://pay.qitianyu.cn/', //需要带上斜杠和http或https
    'pay_url' => 'https://xxx.xxx/', //需要带上斜杠和http或https
    // 你的系统名称[充值购买的时候用于显示]
    'webname' => '易验云',
    // 底部版权
    'copyright' => '',
    // 底部备案
    'beian' => '',
    // 版权时间
    'copyright_time' => '',
    // 名称
    'nick' => 'YIYANYUN',
    // 网站标题
    'web_title' => 'YIYANYUN - 网络验证',
    // 网站链接
    'web_url' => '',
];


