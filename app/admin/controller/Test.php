<?php
/*
 * @Author       : Lucifer
 * @Date         : 2022-05-06 11:00:46
 * @LastEditTime : 2022-05-16 08:04:22
 * @FilePath     : \yiyanyun\app\admin\controller\Test.php
 */

// 当前文件用于测试
namespace app\Admin\controller;

use think\facade\View;

class Test
{
    public function index()
    {
        return view::fetch('/indexs');
    }

    public function test()
    {
    }
}
