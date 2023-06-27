<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 10:24:05
 * @FilePath     : \yiyanyun\app\admin\controller\Index.php
 */

declare(strict_types=1);

namespace app\Admin\controller;

use app\admin\model\Project;
use app\admin\model\Scode;
use app\admin\model\Dcode;
use app\admin\model\User;
use app\admin\model\Agent;
use app\admin\model\UserLog;
use think\facade\view;

class Index
{
    public function index()
    {
        $user = User::count(); // get user the count
        $pro = Project::count(); // get project the count
        $scode = Scode::count(); // get single code the count
        $dcode = dcode::count(); // get double code the count
        $scodes = Scode::where('use_time', 'null')->count(); // get used single code the count 
        $dcodes = Dcode::where('use_time', 'null')->count(); // get used double code the count 
        $agent = Agent::count(); // get agent the count 
        $v_user = user::where('vip', 'null')->count(); // get vip user the count
        $active = UserLog::order('id desc')->limit(5)->select()->toArray(); //find 5 datas
        $use = $scode - $scodes; //VS可能会有点误报错说找不到类型只找到文件路径，不过没影响能正常运行
        // start data rendering 
        view::assign([
            'server'    =>  php_uname(),
            'ServerIP'  =>  GetHostByName($_SERVER['SERVER_NAME']),
            'version'   =>  config('web.version'),
            'user'      =>  $user,
            'users'     =>  $user,
            'code'      =>  $scode,
            'pro'       =>  $pro,
            'dcode'     =>  $dcode,
            'use_code'  =>  $use,
            'agent'     =>  $agent,
            'use_dcode' =>  $dcodes,
            'vip_user'  =>  $v_user,
            'active'    =>  $active
        ]);
        return view::fetch('/index');
    }
}
