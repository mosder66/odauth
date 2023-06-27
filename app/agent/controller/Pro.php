<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-03-19 20:45:07
 * @LastEditTime : 2022-05-08 20:04:11
 * @FilePath     : \yiyanyun\app\agent\controller\Pro.php
 */
namespace app\agent\controller;
use think\facade\View;
use app\agent\model\AgPro;
class Pro 
{
    public function index()
    {
        $list = agpro::where('aid',aid())->order('id', 'desc')->paginate(10);
        $page = $list->render();
        return view::fetch('/pro',['list'=>$list,'page'=>$page]);
    }
}
