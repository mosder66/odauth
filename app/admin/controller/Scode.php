<?php

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

namespace app\Admin\controller;

use app\admin\model\Project;
use think\facade\View;
use app\admin\model\Scode as code;
use think\Request;

class Scode
{
    /**
     * 卡密页面
     */
    public function index()
    {
        $list = code::order('id', 'desc')->paginate(30);
        $page = $list->render();
        return view::fetch('/scode', ['list' => $list, 'page' => $page]);
    }

    /**
     * 单码卡密添加页面
     */
    public function scodeadd()
    {
        $list = project::paginate();
        return view::fetch('/scodeadd', ['list' => $list]);
    }

    /**
     * 单码卡密添加页面
     */
    public function scode()
    {
        $list = project::paginate();
        return view::fetch('/scodeadd', ['list' => $list]);
    }

    /**
     * 添加卡密[虽然代码可能有点长而且难看懂但是实际上还是很容易的]
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $kami_tatol = input('post.kami_tatol');
            $kami_lenght = input('post.kami_lenght');
            $kami_trait = input('post.kami_trait');
            $project_id = input('post.project_id');
            $kami_value = input('post.kami_value');

            // 开始判断卡密长度
            if ($kami_lenght == 1) {
                $lenght = 10;
            } elseif ($kami_lenght == 2) {
                $lenght = 18;
            } elseif ($kami_lenght == 3) {
                $lenght = 32;
            } elseif ($kami_lenght == 4) {
                $lenght = 40;
            } else {
                return jsons(201, '没有你想要的卡密长度');
            }

            // 开始判断时长或值
            if ($kami_value == 1) {
                $value = 1;
            } elseif ($kami_value == 2) {
                $value = 3;
            } elseif ($kami_value == 3) {
                $value = 7;
            } elseif ($kami_value == 4) {
                $value = 30;
            } elseif ($kami_value == 5) {
                $value = 365;
            } elseif ($kami_value == 6) {
                $value = -1;
            } else {
                return jsons(201, '没有你想要的类型');
            }

            for ($i = 1; $i <= $kami_trait; $i++) {
                if ($kami_tatol == 'Single') {
                    $key = get_code($lenght);
                } elseif ($kami_tatol == 'uppercase') {
                    $key = strtoupper(get_code($lenght));
                } else {
                    return jsons(201, '没有你想要的类型');
                }

                // 组合数据写入数据库
                $data = [
                    'pid' => $project_id,
                    'kami' => $key,
                    'time' => time(),
                    'value' => $value,
                    'operator' => '管理员'
                ];
                $res = code::insert($data);
                if (empty($res)) {
                    return jsons(201, '生成失败');
                }
            }
            return json(array('code' => 200, 'msg' => '生成成功', 'time' => time()));
        }
    }

    /**
     * 删除卡密
     */
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
                $res = code::where('id', 'in', $where)->delete();
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }

    /**
     * 禁用卡密
     * @param id array
     */
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
                $res = code::where('id', 'in', $where)->update(['status' => 'n']);
                if ($res) {
                    return jsons(200, '操作成功');
                }
                return jsons(201, '操作失败');
            } else {
                return jsons(201, '没有选择数据');
            }
        }
    }

    /**
     * 启用卡密
     * @param id array id值
     */
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
                $res = code::where('id', 'in', $where)->update(['status' => 'y']);
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
