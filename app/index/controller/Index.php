<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-07-01 17:31:02
 * @FilePath     : \yiyanyun\app\index\controller\Index.php
 */

declare(strict_types=1);

namespace app\Index\controller;

use think\facade\View;
use think\Request;

class Index
{
    public function index(Request $request)
    {
        view::assign([
            'ip'    =>  $request->ip()
        ]);
        return View::fetch();
        // return '您好！这是一个[Index]示例应用';
    }
}
