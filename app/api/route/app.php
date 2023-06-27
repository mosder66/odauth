<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-25 15:15:34
 * @FilePath: \yiyanyun\app\api\route\app.php
 */
use think\facade\Route;

//以GET方法获取到code值
Route::get('/:code','index/index');
//以POST方法获取到POST值
Route::post('/:code','index/index');

// 也可采用任何方法获取，此处为了简洁就注释了
// Route::any('/:code','index/index');