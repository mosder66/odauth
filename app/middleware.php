<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-12 08:17:49
 * @FilePath: \yiyanyun\app\middleware.php
 */
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    \think\middleware\SessionInit::class
];
