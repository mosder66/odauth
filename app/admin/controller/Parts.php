<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-13 09:59:59
 * @LastEditTime : 2022-07-01 17:38:45
 * @FilePath     : \yiyanyun\app\admin\controller\Parts.php
 */

/**
 * 这个是插件文件，但是版本未启用插件模式
 */
namespace app\admin\controller;
use app\admin\model\Admin;
use think\facade\View;

class Parts
{
    public function index()
    {
        return view::fetch('/parts');
    }
}