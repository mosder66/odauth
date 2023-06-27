<?php
/*
 * @Author       : Lucifer
 * @Date         : 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-05 09:05:43
 * @FilePath     : \yiyanyun\app\admin\controller\Proclone.php
 */
namespace app\Admin\controller;
use think\facade\View;
use think\Request;
class Proclone
{
    //这里本打算写个克隆接口但是考虑到小服务器带宽也小没有说明好办法能够更好解决也就暂时放弃

    
    public function index()
    {
        return view::fetch('/proclone');
    }

    public function submit(Request $request)
    {
        if($request->isPost()){
            return '';
        }
    }
}