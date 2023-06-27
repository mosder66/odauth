<?php

namespace app\Admin\controller;

use app\admin\model\Project as pro;
use app\admin\model\Scode;
use app\admin\model\User;
use app\admin\model\Api;
use think\facade\View;
use think\Request;

class Project
{
    public function index()
    {
        $list = pro::order('id', 'desc')->paginate(50);
        $page = $list->render();
        return view::fetch('/project', ['list' => $list, 'page' => $page]);
    }

    public function del(Request $request)
    {
        if ($request->isPost()) {
            $id = input('post.id');
            if ($id) {
                $ids = '';
                foreach ($id as $value) {
                    $ids .= intval($value) . ",";
                }
                $where = explode(",", $ids);
                $ids = rtrim($ids, ",");
                $res = pro::where('id', 'in', $where)->delete();
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }

    public function jstatus(Request $request)
    {
        if ($request->isPost()) {
            $id = input('post.id');
            if ($id) {
                $ids = '';
                foreach ($id as $value) {
                    $ids .= intval($value) . ",";
                }
                $where = explode(",", $ids);
                $ids = rtrim($ids, ",");
                $res = pro::where('id', 'in', $where)->update(['status' => 'n']);
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }

    public function qstatus(Request $request)
    {
        if ($request->isPost()) {
            $id = input('post.id');
            if ($id) {
                $ids = '';
                foreach ($id as $value) {
                    $ids .= intval($value) . ",";
                }
                $where = explode(",", $ids);
                $ids = rtrim($ids, ",");
                $res = pro::where('id', 'in', $where)->update(['status' => 'y']);
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }

    public function proadd()
    {
        return view::fetch('/proadd');
    }

    public function proadds(Request $request)
    {
        if ($request->isPost()) {
            $name = input('post.name');
            $version = input('post.version');
            if ($name == null) {
                return jsons(201, '请输入完整');
            }
            $users = pro::where('name', $name)->find();
            if (!empty($users)) {
                return jsons(201, '项目名已存在');
            }
            $key = strtoupper(get_code(15));
            $res = pro::insert([
                'name' => $name,
                'key' => $key,
                'version' => $version,
                'time' => time()
            ]);
            if (empty($res)) {
                return jsons(201, '操作失败');
            }
            return jsons(200, '操作成功');
        }
    }

    public function proedit(Request $request)
    {
        if ($request->isGet()) {
            $res = input('get.id');
            if (empty($res)) {
                // return jsons(201,'请重新发起请求');
                return '似乎找不到项目哦~确保是正确的项目ID';
                return jsons(201, $res);
            }
            $project = pro::where(['id' => $res])->find();
            $user = user::where('pid', $res)->count();
            $kami = Scode::where('pid', $res)->count();
            $api = api::where('pid', $res)->count();

            view::assign([
                'user' => $user,
                'kami' => $kami,
                'api' => $api,
                'id' => $project['id'],
                'name' => $project['name'],
                'key' => $project['key'],
                'status' => $project['status'],
                'landing' => $project['landing'],
                'add_time' => $project['add_time'],
                'encrypt' => $project['encrypt'],
                'check' => $project['check'],
                'encrypt_des' => $project['key_des'],
                'encrypt_rc4' => $project['key_rc4'],
                'encrypt_rsa_public' => $project['encrypt_rsa_public'],
                'encrypt_rsa_private' => $project['encrypt_rsa_private'],
                'reg_status' => $project['reg_status'],
                'reg_machine' => $project['reg_machine'],
                'login_status' => $project['login_status'],
                'login_machine' => $project['login_machine'],
                'login_Interval' => $project['login_Interval'],
                'login_mac' => $project['login_mac'],
                'login_sgin' => $project['login_sgin'],
                'kami_status' => $project['kami_status'],
                'kami_sgin' => $project['kami_sgin'],
                'kami_mac' => $project['kami_mac'],
                'kami_Interval' => $project['kami_Interval'],
            ]);
            return view::fetch('/proedit',['project'=>$project]);
        }
    }

    public function reg_submit(Request $request)
    {
        if ($request->isPost()) {
            $Interval = input('post.Interval');
            $id = input('post.id');
            $res = pro::where('id', $id)->update([
                'reg_Interval' => $Interval
            ]);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function login_submit(Request $request)
    {
        if ($request->isPost()) {
            $Interval = input('post.login_Interval');
            $id = input('post.id');
            $sgin = input('post.sgin');
            $mac = input('post.login_mac');
            $data = [
                'login_interval' => $Interval,
                'user_sgin' => $sgin,
                'login_mac' => $mac,
            ];
            $res = pro::where('id', $id)->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function kami_submit(Request $request)
    {
        if ($request->isPost()) {
            $id = input('post.id');
            $Interval = input('post.kami_Interval');
            $mac = input('post.mac');
            $sgin = input('post.sgin');
            $data = [
                'kami_interval' => $Interval,
                'kami_mac' => $mac,
                'kami_sgin' => $sgin
            ];
            $res = pro::where('id', $id)->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function mail_submit(Request $request)
    {
        if ($request->isPost()) {
            $id = input('post.id');
            $password = input('post.password');
            $user = input('post.user');
            $post = input('post.port');
            $host = input('post.host');
            $data = [
                'smtp_host' => $host,
                'smtp_user' => $user,
                'smtp_port' => $post,
                'smtp_password' => $password
            ];
            $res = pro::where('id', $id)->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function submit_encrypt(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $data = [
                'submit_encrypt'    =>  $input['submit_encrypt']
            ];
            $res = pro::where('id', $input['id'])->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function return_encrypt(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $data = [
                'encrypt'   =>  $input['return_encrypt'],
                'key_aes'   =>  $input['aes']
            ];
            $res = pro::where('id', $input['id'])->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function data_submit(Request $request)
    {
        if ($request->isPost()) {
            $data_time = input('post.data_time');
            $data_sign = input('post.data_sign');
            $id = input('post.id');
            $data = [
                'data_time' => $data_time,
                'data_sgin' => $data_sign
            ];
            $res = pro::where('id', $id)->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }

    public function pro_submit(Request $request)
    {
        if ($request->isPost()) {
            $pro_name = input('post.pro_name');
            $id = input('post.id');
            $data = [
                'name' => $pro_name
            ];
            $res = pro::where('id', $id)->update($data);
            if ($res) {
                return jsons(200, '操作成功');
            }
            return jsons(201, '操作成功');
        }
    }
}
