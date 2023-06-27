<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-13 17:01:42
 * @FilePath     : \yiyanyun\app\admin\controller\Login.php
 */

/*
 *                                                     __----~~~~~~~~~~~------___
 *                                    .  .   ~~//====......          __--~ ~~
 *                    -.            \_|//     |||\\  ~~~~~~::::... /~
 *                 ___-==_       _-~o~  \/    |||  \\            _/~~-
 *         __---~~~.==~||\=_    -_--~/_-~|-   |\\   \\        _/~
 *     _-~~     .=~    |  \\-_    '-~7  /-   /  ||    \      /~
 *   .~       .~       |   \\ -_    /  /-   /   ||      \   /
 *  /  ____  /         |     \\ ~-_/  /|- _/   .||       \ /
 *  |~~    ~~|--~~~~--_ \     ~==-/   | \~--===~~        .\
 *           '         ~-|      /|    |-~\~~       __--~~
 *                       |-~~-_/ |    |   ~\_   _-~            /\
 *                            /  \     \__   \/~                \__
 *                        _--~ _/ | .-~~____--~-/                  ~~==.
 *                       ((->/~   '.|||' -_|    ~~-/ ,              . _||
 *                                  -_     ~\      ~~---l__i__i__i--~~_/
 *                                  _-~-__   ~)  \--______________--~~
 *                                //.-~~~-~_--~- |-------~~~~~~~~
 *                                       //.-~~~--\
 *                       ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * 
 *                               神兽保佑            永无BUG
 */

namespace app\Admin\controller;

use think\Request;
use think\facade\View;
use app\admin\model\Admin;
use app\admin\model\Log;
use think\facade\Session;

class Login
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
                return json(array('code' => 204, 'msg' => '请填填写完整', 'time' => time()));
            }
            if (!empty(session::get('error'))) {
                if (session::get('error')['second'] > 5) {
                    $error = session::get('error')['time'] - time();
                    if ($error > 0) {
                        return jsons(199, '您的登录错误次数过多触发安全响应请两小时后重试');
                    }
                }
            }
            $res = Admin::where(['user' => $user, 'password' => $password])->find();
            if (empty($res)) {
                if (empty(session::get('error'))) {
                    $a = '1';
                } else {
                    $a = session::get('error')['second'] + 1;
                }
                session::set('error', ['second' => $a, 'time' => time() + 1800]);
                return json(array('code' => 206, 'msg' => '账号密码有误', 'time' => key_code()));
            }
            $log_data = [
                'ip' => getip(),
                'time' => time(),
                'type' => '登录'
            ];
            log::insert($log_data);
            $log = log::insert($log_data);
            if (empty($log)) {
                return jsons(204, '日志写入失败');
            }
            session::clear();
            session::set('token', $log_data);
            if (!empty($res['mail'])) {
                // 需要开启后台登录邮件提醒的请到后台打开此功能，前提是配置好邮箱的信息
                if ($res['remind'] == 'y') {
                    mail_send($res['mail'], '尊敬的站长您好，后台已被重新登录IP：【' . getip() . '】 ，如非您所操作请立即查看详情', '易验云网络验证后台登录提醒');
                }
            }
            return json(array('code' => 200, 'msg' => '验证身份成功', 'time' => key_code()));
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        // 清除session
        session::clear();
        // 重定向到登录页面
        redirect('/admin/login');
        // 重定向失败则让它有点东西显示
        return view::fetch('/login');
    }
}
