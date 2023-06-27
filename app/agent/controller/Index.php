<?php
/*
 * @Author: Lucifer
 * @Date: 2022-03-19 20:07:11
 * @LastEditTime : 2022-05-08 20:02:53
 * @FilePath     : \yiyanyun\app\agent\controller\Index.php
 */
declare (strict_types = 1);
namespace app\agent\controller;
use think\facade\View;
use app\agent\model\Scode;
use app\agent\model\AgPro;
class Index
{
    public function index()
    {
        $scode = scode::where('operator',aid())->count();
        $use = scode::where('operator',aid())->where('use_time',null)->count();
        $pro = agpro::where('aid',aid())->count();
        view::assign([
            'code'=>$scode,
            'id'=>aid(),
            'pro'=>$pro,
            'use_code'=>$use
        ]);
        return view::fetch('/index');
    }
}
