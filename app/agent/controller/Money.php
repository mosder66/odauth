<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-12 09:01:30
 * @LastEditTime : 2022-05-08 20:04:21
 * @FilePath     : \yiyanyun\app\agent\controller\Money.php
 */


// 未完成文件预计完成后代理能够通过在线充值方式充值余额，收款方在管理员后台可配置
namespace app\agent\controller;
use think\facade\View;
use think\Request;
use app\agent\model\AgPro;
use app\agent\model\AgentOrder;
use app\agent\model\Agent;
class Money 
{
    public function index()
    {
        $list = agpro::where('aid',aid())->paginate();
        return view::fetch('/money',['list'=>$list]);
    }

    public function recharge(Request $request)
    {
        if ($request->isPost()) {
            $data = input();
            $type = input('post.type'); //支付方式
            if ($type == '1') {
                $type = 'wxpay';
            } elseif ($type == '2') {
                $type = 'alipay';
            }else{
                return '不支持的支付方式';
            }
            $money = input('post.balance');
            if ($money <= 0 || !is_numeric($money)) {
                return jsons(201, '金额不符合');
            }
            $shop = '零钱充值'; //商品名字
            $name = '零钱充值'; //网站名字
            $webname = '易验云';
            $pid = config('web.pay_id'); //商户id
            $notify_url = config('web.notify_url');
            $return_url = config('web.return_url');
            $pay_key = config('web.pay_key'); //这是您的密钥
            $out_trade_no = time();
            $sgi = 'money=' . $money . '&name=' . $name . '&notify_url=' . $notify_url . '&out_trade_no=' . $out_trade_no . '&pid=' . $pid . '&return_url=' . $return_url . '&sitename=' . $webname . '&type=' . $type . $pay_key;
            $sgin = md5($sgi);
            $url = config('web.pay_url') . "submit.php?pid=" . $pid . "&type=" . $type . "&out_trade_no=" . $out_trade_no . "&notify_url=" . $notify_url . "&return_url=" . $return_url . "&name=" . $shop . "&money=" . $money . "&sitename=" . $webname . "&sign=" . $sgin . "&sign_type=MD5";

            agentorder::insert(['aid' => aid(), 'ip' => getip(), 'time' => time(), 'order' => $out_trade_no, 'money' => $money, 'status' => 'n']);
            return json(array('code' => 200, 'msg' => '发起支付成功', 'url' => $url));
        }
    }


    public function notify()
    {
        ksort($_GET); //排序post参数
        reset($_GET); //内部指针指向数组中的第一个元素
        $codepay_key = config('web.pay_key'); //这是您的密钥
        $sign = "money=" . $_GET['money'] . "&name=" . $_GET['name'] . "&out_trade_no=" . $_GET['out_trade_no'] . "&pid=" . $_GET['pid'] . "&trade_no=" . $_GET['trade_no'] . "&trade_status=" . $_GET['trade_status'] . "&type=" . $_GET['type'];
        if (!$_GET['trade_no'] || md5($sign . $codepay_key) != $_GET['sign']) { //不合法的数据
            return '订单异常如已支付请联系人工客服先发支付流水号给予基础上加以补偿';
        } else { //合法的数据
            //业务处理
            $money = (float)$_GET['money'];
            $pay_no = $_GET['trade_no'];
            $balance = Agent::where('id', aid())->find();
            $res = $balance['balance'] + $money;
            $data = [
                'balance' => $res
            ];
            $der = AgentOrder::where('order', $pay_no)->find();
            if (empty($der)) {
                Agent::where('id', aid())->update($data);
                AgentOrder::insert(['aid' => aid(), 'ip' => getip(), 'time' => time(), 'order' => $pay_no, 'money' => $money, 'status' => 'y']);
            }
            view::assign([
                'user' => aid(),
                'name' => $pay_no,
                'money' => $money,
                'balance' => $res
            ]);
            return view::fetch('/pay_ok');
            //支付成功后逻辑代码
            exit('success'); //返回成功 不要删除哦
        }
        return 'end';
    }
}