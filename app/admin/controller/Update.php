<?php
/*
 * @Author: Lucifer
 * @Date: 2022-03-15 14:34:26
 * @LastEditTime : 2022-05-06 15:09:09
 * @FilePath     : \yiyanyun\app\admin\controller\Update.php
 */

/**
 * 本想写一个一体的更新结构但是出于某些原因暂未完成
 */
namespace app\Admin\controller;
use think\facade\View;

class update
{
    public function index()
    {
        return view::fetch('/update');
    }
}
