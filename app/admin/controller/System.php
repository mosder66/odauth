<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime : 2022-06-01 08:36:46
 * @FilePath     : \yiyanyun\app\admin\controller\System.php
 */

namespace app\Admin\controller;

use think\facade\View;
use think\Request;
use app\admin\model\Admin;

class system
{
    public function index()
    {
        return view::fetch('/system');
    }

    public function Submit(Request $request)
    {
        if ($request->isPost()) {
            $web_site_title = input('post.web_site_title');
            $web_site_copyright = input('post.web_site_copyright');
            $web_site_icp = input('post.web_site_icp');

            $data = [
                'web_title' => $web_site_title,
                'beian' => $web_site_icp,
                'copyright' => $web_site_copyright
            ];

            $res = Admin::where('id', 1)->update($data);
            if (empty($res)) {
                return jsons(201, '保存成功');
            }
            return jsons(200, '保存成功');
        }
    }

    public function update()
    {
        $view = Admin::where('id', 1)->find();
        if (empty($view['yun_token'])) {
            return view::fetch('/yun');
        }
        $url = config('web.yun_api') . 'index/update';
        $res = request_curl($url, 'token=' . $view['yun_token']);
        if (!is_json($res)) {
            return view::fetch('/error', ['reason' => '服务器链接失败，请检查服务器地址是否正确，或可尝试到官网获取新的地址接口！！！']);
        }
        $data = json_decode($res, true);
        if ($data['code'] == 200) {
            return view::fetch('/update', ['info' => $data['msg'], 'size' => getFileSize($data['msg']['url']), 'disabled' => 'disabled0']);
        } else {
            return view::fetch('/error', ['reason' => $data['msg']]);
        }
    }

    public function down()
    {
        $view = Admin::where('id', 1)->find();
        if (empty($view['yun_token'])) {
            return view::fetch('/yun');
        }
        $url = config('web.yun_api') . 'index/update';
        $res = request_curl($url, 'token=' . $view['yun_token']);
        if (!is_json($res)) {
            return view::fetch('/error', ['reason' => '服务器链接失败，请检查服务器地址是否正确，或可尝试到官网获取新的地址接口！！！']);
        }
        $data = json_decode($res, true);
        if ($data['code'] == 200) {
            // return view::fetch('/update', ['info' => $data['msg'], 'size' => getFileSize($data['msg']['url']), 'disabled' => 'disabled0']);
            $save_dir = "../package/"; // 服务资源目录
            $filename = "package.zip"; // 自定义名称
            getFile($data['msg']['url'], $save_dir, $filename, 1);
            // 下载更新包完成
            // 开始解压更新
            $up = unzip('package.zip');
            if ($up) {
                return jsons(200, '更新完成');
            } else {
                return jsons(200, '更新失败 请反馈情况');
            }
        } else {
            return view::fetch('/error', ['reason' => $data['msg']]);
        }
    }

    public function test()
    {
        unzip('../package/1.zip', '../app/admin/controller/');
        return;
    }
}
