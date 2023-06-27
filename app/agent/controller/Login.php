<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-12 09:05:22
 * @FilePath: \yiyanyun\app\agent\controller\Login.php
 */
namespace app\agent\controller;
use think\facade\View;
use app\agent\model\Agent;
use app\agent\model\Aglog;
use think\Request;
use think\facade\Session;
class login 
{
    public function index()
    {
        return view::fetch('/login');
    }

    public function login(Request $request)
    {
        if ($request->isPost()) {
            $user = input('post.user');
            $password = input('post.password');
            if ($user == '' || $password == '') {
                return json(array('code' => 204, 'msg' => '请填写完整', 'time' => time()));
            }

            $res = agent::where(['user'=>$user,'password'=>$password])->find();
            if (empty($res)) {
                return json(array('code' => 206, 'msg' => '账号或密码有误', 'time' => time()));
            }
            $token = make_token();
            $data = [
                'aid' => $res['id'],
                'ip' => getip(),
                'token' => $token,
                'time' => time()
            ];
            aglog::insert($data);
            $log = agent::where('id', $res['id'])->update(['token' => $token]);
            if (empty($log)) {
                return json(array('code' => 201, 'msg' => '登陆异常', 'time' => time()));
            }
            session::set('tokens', $data);
            return json(array('code' => 200, 'msg' => '登录成功', 'time' => time()));
        }
    }
}