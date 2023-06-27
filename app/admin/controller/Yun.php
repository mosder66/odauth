<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-07-01 17:17:42
 * @FilePath     : \yiyanyun\app\admin\controller\Yun.php
 */

/**
 * 这个是云端绑定文件
 * 如您尊重本代码请您勿擅自改动
 * 暂未写完
 */

namespace app\Admin\controller;

use think\facade\View;
use app\admin\model\Admin;
use think\Request;

class Yun
{
    public function index()
    {
       return view::fetch('/yun');
    }
}
