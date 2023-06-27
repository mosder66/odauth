<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 20:14:30
 * @FilePath     : \yiyanyun\app\agent\middleware\Auth.php
 */

declare(strict_types=1);

namespace app\agent\middleware;

use think\facade\Session;
use think\facade\View;

class auth
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
        // 添加中间件执行代码
        $pathInfo = str_replace('.' . $request->ext(), '', $request->pathInfo());
        $action = explode('/', $pathInfo)[0];
        if ($action !== 'login'&&$action!='reg') {
            if (!Session::get('tokens')) {
                if ($request->isAjax()) {
                    //
                } else {
                    redirect('/agent/login')->send();
                    exit;
                }
            }
        }
        View::assign([
            'aid' => aid()
        ]);
        return $next($request);
    }
}
