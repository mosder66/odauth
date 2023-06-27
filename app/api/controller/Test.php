<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-15 08:53:50
 * @LastEditTime: 2022-04-25 11:30:42
 * @FilePath: \yiyanyun\app\api\controller\Test.php
 */
namespace app\api\controller;
use app\api\model\Userlog;
use think\Request;
class Test 
{
    public function index()
    {
        $a = Userlog::where('id',1)->find();
        echo $a;
        echo '<hr>';
        return $a->user;
    }

    public function test()
    {
        Request::post();
    }
}