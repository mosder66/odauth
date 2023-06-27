<?php 

namespace app\Admin\controller;
use think\facade\View;
use think\Request;
use app\admin\model\Api as apis;
use app\admin\model\Project;

class api
{
    public function index()
    {
        $list = apis::order('id', 'desc')->paginate(50);
        $page = $list->render();
        $plist = Project::paginate();
        view::assign([
            'url'=>input('server.REQUEST_SCHEME') . '://' . input('server.SERVER_NAME')
        ]);
        return view::fetch('/api',['list'=>$list,'page'=>$page,'plist'=>$plist]);
    }

    public function generate(Request $request)
    {
        if ($request->isPOST()) {
            $pid = input('post.pid');
            $operation = input('post.operation');
            $existence = apis::where(['pid'=>$pid,'operation'=>$operation])->find();
            if (!empty($existence)) {
                return jsons(203,'接口已存在');
            }
            $code = get_code(10);
            $data = [
                'code' => $code,
                'pid' => $pid,
                'time' => time(),
                'operation' => $operation
            ];
            $res = apis::insert($data);
            if (!empty($res)) {
                return jsons(200,'操作成功');
            }
            return jsons(201,'操作失败');
        }
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
                $res = apis::where('id', 'in', $where)->delete();
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
                $res = apis::where('id', 'in', $where)->update(['status' => 'n']);
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
                $res = apis::where('id', 'in', $where)->update(['status' => 'y']);
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }
}