<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 10:00:38
 * @FilePath     : \yiyanyun\app\admin\middleware\Auth.php
 */

/*
 *                                                     __----~~~~~~~~~~~------___
 *                                    .  .   ~~//====......          __--~ ~~
 *                    -.            \_|//     |||\\  ~~~~~~::::... /~
 *                 ___-==_       _-~o~  \/    |||  \\            _/~~-
 *         __---~~~.==~||\=_    -_--~/_-~|-   |\\   \\        _/~
 *     _-~~     .=~    |  \\-_    '-~7  /-   /  ||    \      /
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

declare(strict_types=1);

namespace app\admin\middleware;

use think\facade\Session;
use think\facade\View;

class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 中间件代码开始

        /**
         * 根据时间去判断主题的选择
         */
        $time = date('H');
        if ($time > 20) {
            view::assign([
                'theme' => 'dark'
            ]);
        } else {
            view::assign([
                'theme' => 'default'
            ]);
        }
        /**
         * 登录验证判断
         * 获取登录的session值
         */
        $action = $request->pathInfo();
        if ($action !== 'login') {
            if (empty(Session::get('token'))) {
                // 判断是否为Ajax
                if (!$request->isAjax()) {
                    redirect('/admin/login')->send();
                    exit;
                }
            }
        }
        /**
         * 中间件渲染前端
         */
        View::assign([
            'copyright' => config('web.copyright'),
            'beian' => config('web.beian'),
            'copyright_time' => config('web.copyright_time'),
            'nick' => config('web.nick'),
            'web_title' => config('web.web_title')
        ]);
        return $next($request);
    }
}
