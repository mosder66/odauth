<?php
/*
 * @Author       : Lucifer
 * @Date         : 2022-05-28 14:51:43
 * @LastEditTime : 2022-05-28 21:31:52
 * @FilePath     : \yiyanyun\app\admin\controller\Shop.php
 */

namespace app\Admin\controller;

use think\facade\View;
use think\Request;
use app\admin\model\shop as shops;

class Shop
{
    public function index()
    {
        return view::fetch('/shop');
    }

    public function add(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $info = Shops::where('name',$input['name'])->find();
            if (!empty($info)) {
                return jsons(201, '商品已存在');
            }
            $data = [
                'name' => $input['name'],
                'name' => $input[''],
                'name' => $input[''],
                'name' => $input['']
            ];
        }
    }

    /**
     * @param
     */
    public function del(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $info = Shops::where('id',$input['id'])->find();
            if (empty($info)) {
                return jsons(201, '商品不存在');
            }
            $del = shops::where('id',$info['id'])->delete();
            if (empty($del)) {
                return jsons(201,'删除失败');
            }else{
                return jsons(200,'删除成功');
            }
        }
    }

    public function edit(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $info = Shops::where('id',$input['id'])->find();
            if (!empty($info)) {
                return jsons(201, '商品不存在');
            }else{
                return view::fetch('/shop_edit',['info'=>$info]);
            }
        }
    }

    public function edits(Request $request)
    {
        if ($request->isPost()) {
            $input = input();
            $info = Shops::where('id',$input['id'])->find();
            if (!empty($info)) {
                return jsons(201, '商品不存在');
            }else{
                $data = [
                    'name' => $info['name'],
                    'name' => $info['name'],
                    'name' => $info['name'],
                    'name' => $info['name'],
                    'name' => $info['name'],
                ];
            }
        }
    }
}
