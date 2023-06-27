<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 16:28:51
 * @FilePath     : \yiyanyun\app\admin\middleware.php
 */

// 这是系统自动生成的middleware定义文件
return [
    // 开启session
    \think\middleware\SessionInit::class,
    // 注册一个Auth的中间件
    app\admin\middleware\Auth::class
];
