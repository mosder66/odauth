<?php
/*
 *                   ___====-_  _-====___
 *             _--^^^#####//      \\#####^^^--_
 *          _-^##########// (    ) \\##########^-_
 *         -############//  |\^^/|  \\############-
 *       _/############//   (@::@)   \############\_
 *      /#############((     \\//     ))#############\
 *     -###############\\    (oo)    //###############-
 *    -#################\\  / VV \  //#################-
 *   -###################\\/ .  . \//###################-
 *  _#/|##########/\######(   /\   )######/\##########|\#_
 *  |/ |#/\#/\#/\/  \#/\##\  |  |  /##/\#/  \/\#/\#/\#| \|
 *  `  |/  V  V  `   V  \#\| |  | |/#/  V   '  V  V  \|  '
 *     `   `  `      `   / | |  | | \   '      '  '   '
 *                      (  | |  | |  )
 *                     __\ | |  | | /__
 *                    (vvv(VVV)(VVV)vvv)
 * 
 *      ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * 
 *                三神护体           绝无BUG
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
 *                               神兽护体            永无BUG
 */

/*
 * @Author: Lucifer
 * @Date: 2022-04-15 08:53:50
 * @LastEditTime: 2022-04-20 09:22:30
 * @FilePath: \yiyanyun\app\api\controller\Index.php
 */


// 本程序目前为学习，请勿用于非法用途，否则所使用造成将承担所有的后果

declare(strict_types=1);

namespace app\Api\controller;

use think\facade\View;
use app\api\model\Scode;
use app\api\model\Ucode;
use app\api\model\User;
use app\api\model\Plog;
use app\api\model\Project as pro;
use app\api\model\Apicode;
use app\api\model\UserLog;
use app\api\model\Dcode;
use app\api\model\UserMac;
use app\api\model\CodeLog;
use app\api\model\CodeMac;
use app\api\model\Message;
use app\api\model\Notice;

class Index
{
    public $enc;

    function index($code = '')
    {
        // 获取对接码
        $api = Apicode::where('code', $code)->find();
        if (empty($api)) return view::fetch('index@index');
        // 更新请求接口次数
        Apicode::where('id', $api['id'])->update(['request' => $api['request'] + 1]);
        // 查找对应的项目
        $pro = pro::where('id', $api['pid'])->find();
        // 判断接口是否已被关闭
        if ($api['status'] == 'n') return jsons(234, '', $pro);
        // 项目已关闭
        if ($pro['status'] == 'n') return jsons(235, '', $pro);
        // 获取提交签名【如果后台设置则需必填】

        // 判断提交加密类型
        if ($pro['submit_encrypt'] == '1') {
            if (!array_key_exists('data', $_REQUEST)) return jsons(197, '', $pro);
            $data = $_POST['data'];
            $data_arr = base64_decode($data);
            $data_arr = txt_Arr($data_arr);
        } elseif ($pro['submit_encrypt'] == '2') {
            if (!array_key_exists('data', $_REQUEST)) return jsons(197, '', $pro);
            $data = $_POST['data'];
            $data_arr = openssl_decrypt($data, 'AES-128-ECB', $pro['key_aes'], 0);
            $data_arr = txt_Arr($data_arr);
        } else {
            $data_arr = $_REQUEST;
        }
        // 开始判断需要执行的操作
        switch ($api['operation']) {
            case 'info': //项目信息1
                return $this->info($data_arr, $pro);
                break;
            case 'register': //用户注册2
                return $this->register($pro, $data_arr);
                break;
            case 'login': //用户登录3
                return $this->login($data_arr, $pro);
                break;
            case 'palpitate': //用户心跳4
                return $this->palpitate($data_arr, $pro);
                break;
            case 'changePassword': //用户修改密码5
                return $this->changePassword($data_arr, $pro);
                break;
            case 'user_toup': //用户充值6
                return $this->user_toup($data_arr, $pro);
                break;
            case 'kami_login': //卡密登录7
                return $this->kami_login($data_arr, $pro);
                break;
            case 'getUserInfo': //查询用户信息8
                return $this->getUserInfo($data_arr, $pro);
                break;
            case 'user_sgin': //用户签到9
                return $this->user_sgin($data_arr, $pro);
                break;
            case 'kami_sgin': //卡密签到10
                return $this->kami_sgin($data_arr, $pro);
                break;
            case 'getkamiInfo': //查询卡密信息11
                return $this->getkamiInfo($data_arr, $pro);
                break;
            case 'vip_ver': //会员验证13
                return $this->vip_ver($data_arr, $pro);
                break;
            case 'dcode_login': //双卡登录14
                return $this->dcode_login($data_arr, $pro);
                break;
            case 'dcode_unbin': //双卡解绑15
                return $this->dcode_unbin($data_arr, $pro);
                break;
            case 'dcode_info': //双卡信息16
                return $this->dcode_info($data_arr, $pro);
                break;
            case 'user_logout': //双卡签到17
                return $this->user_logout($data_arr, $pro);
                break;
            case 'scode_renew': //单卡续费
                return $this->scode_renew($data_arr, $pro);
                break;
            case 'scode_logout': //单卡推出
                return $this->scode_logout($data_arr, $pro);
                break;
            case 'dcode_sgin': //双卡签到
                return $this->dcode_sgin($data_arr, $pro);
                break;
            case 'notice': //项目通知
                return $this->notice($data_arr, $pro);
                break;
            case 'token_change': //Token更新
                return $this->token_change($data_arr, $pro);
                break;
            case 'user_mess':
                return $this->user_mess($data_arr, $pro);
                break;
            default:
        }
        return '你在想啥？';
    }


    // 下面全是函数

    /**
     * 项目信息获取
     * @param $pro 项目信息
     */
    function info($data_arr, $pro)
    {
        if (!array_key_exists('time', $data_arr)) return jsons(190, '参数不齐', $pro);
        if (empty($data_arr['time'])) return jsons(190, '参数不齐', $pro);
        $row = strval(time()) - $data_arr['time'];
        if ($row > 10) {
            return jsons(199, '本次请求已超时', $pro);
        }
        $data = [
            'name' => $pro['name'],
            'key' => $pro['key'],
        ];
        return jsons(200, $data, $pro);
    }

    /**
     * 用户登录
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function login($data_arr, $pro)
    {
        if ($pro['login_status'] == 'n') return jsons(198, '', $pro);
        if (!array_key_exists('user', $data_arr)) return jsons(202, '', $pro);
        if (!array_key_exists('password', $data_arr)) return jsons(203, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);
        $token = getcode(32);
        $user = User::where(['pid' => $pro['id'], 'user' => $data_arr['user'], 'password' => md5($data_arr['password'])])->find();
        if (empty($user)) return jsons(204, '', $pro);
        $info = [
            'id' => $user['id'],
            'user' => $user['user'],
            'vip' => $user['vip'],
            'token' => $token
        ];
        $mac = UserMac::where(['pid' => $pro['id'], 'uid' => $user['id']])->count();
        $macs = UserMac::where(['pid' => $pro['id'], 'uid' => $user['id'], 'mac' => $data_arr['mac']])->find();
        if (!empty($macs)) {
            #发现是存在的登录设备
            $run = UserMac::where('id', $macs['id'])->update(['end_time' => time(), 'ip' => getip(), 'mac' => $data_arr['mac']]);
            if (!empty($run)) {
                return jsons(200, $info, $pro);
            } else {
                return jsons(199, '', $pro);
            }
        } elseif ($mac < $pro['login_mac']) {
            #未发现且登录设备数未超过预设定值
            $run = UserMac::insert(['uid' => $user['id'], 'pid' => $pro['id'], 'type' => '登录', 'start_time' => time(), 'end_time' => time(), 'ip' => getip(), 'token' => $token, 'mac' => $data_arr['mac']]);
            if (!empty($run)) {
                return jsons(200, $info, $pro);
            } else {
                return jsons(199, '', $pro);
            }
        } else {
            #已超过预设定值且未在登录设备中
            return jsons(223, '', $pro);
        }
    }

    /**
     * 用户注册
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function register($pro, $data_arr)
    {
        if (!array_key_exists('user', $data_arr)) return jsons(202, '', $pro);
        if (!array_key_exists('password', $data_arr)) return jsons(203, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);
        if (!array_key_exists('mail', $data_arr)) {
            $mail = null;
        } else {
            $mail = $data_arr['mail'];
        }
        if (!array_key_exists('name', $data_arr)) {
            $name = '这个人没有昵称？';
        } else {
            $name = $data_arr['name'];
        }
        $user = user::where(['pid' => $pro['id'], 'user' => $data_arr['user']])->find();
        if (!empty($user)) return jsons(217, '', $pro);
        $info = [
            'pid' => $pro['id'],
            'user' => $data_arr['user'],
            'password' => md5($data_arr['password']),
            'name' => $name,
            'reg_mac' => $data_arr['mac'],
            'reg_ip' => getip(),
            'reg_time' => time(),
            'mail' => $mail,
        ];
        $user = user::insert($info);
        if (empty($user)) {
            return jsons(199, '', $pro);
        } else {
            return jsons(200, '', $pro);
        }
    }

    /**
     * 用户心跳
     * @param $data_arr 输入内容
     * @param $pro 项目 信息
     */
    function palpitate($data_arr, $pro)
    {
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $token = UserMac::where('token', $data_arr['token'])->find();
        if (empty($token)) {
            return jsons(214, '', $pro);
        }
        $user = $token->user;
        if (empty($user)) return jsons(214, '', $pro);
        $up = UserMac::where(['token' => $data_arr['token'], 'pid' => $pro['id']])->update([
            'end_time' => time(),
        ]);
        if (empty($up)) {
            return jsons(199, '更新失败', $pro);
        } else {
            return jsons(200, '更新成功', $pro);
        }
    }

    /**
     * 卡密登录
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function kami_login($data_arr, $pro)
    {
        if (!array_key_exists('scode', $data_arr)) return jsons(206, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);
        $token = getcode(32);
        $info = Scode::where(['kami' => $data_arr['scode'], 'pid' => $pro['id']])->find();
        if (empty($info)) return jsons(207, '', $pro);
        if ($info['status'] == 'n') return jsons(215, '', $pro);

        //开始判定卡密是否已过期
        if ($info['end_time'] < time()) {
            return jsons(209, '', $pro);
        } elseif (!$info['end_time'] == '-1') {
            return jsons(209, '', $pro);
        }

        if (empty($info['use_time'])) {
            if ($info['value'] == '-1') {
                $value = '-1';
            } else {
                $value = time() + 86400 * $info['value'];
            }
            $run = scode::where(['pid' => $pro['id'], 'kami' => $data_arr['scode']])->update(['use_time' => time(), 'end_time' => $value]);
            if (empty($run)) {
                return jsons(199, '', $pro);
            } else {
                Scode::where(['kami' => $data_arr['scode'], 'pid' => $pro['id']])->update(['use_time' => time(), 'end_time' => $value]);
                CodeMac::insert(['code' => $data_arr['scode'], 'pid' => $pro['id'], 'type' => 'scode', 'start_time' => time(), 'end_time' => time(), 'ip' => getip(), 'token' => $token]);
                return jsons(200, '这是新卡密哦', $pro);
            }
        }

        $mac = CodeMac::where(['pid' => $pro['id'], 'code' => $data_arr['scode']])->count();
        $info = ['id' => $info['id'], 'kami' => $info['kami'], 'start_time' => time(), 'end_time' => $info['end_time'], 'value' => $info['value']];
        $find = CodeMac::where(['pid' => $pro['id'], 'code' => $data_arr['scode'], 'mac' => $data_arr['mac']])->find();
        if (!empty($find)) {
            $run = CodeMac::where('id', $find['id'])->update(['end_time' => time(), 'ip' => getip(), 'mac' => $data_arr['mac']]);
            if (!empty($run)) {
                return jsons(200, $info, $pro);
            } else {
                return jsons(199, '', $pro);
            }
        }
        if ($mac <= $pro['kami_mac']) {
            //当前设备登录小于或等于项目设定的设备最大登录数
            $mac = CodeMac::where(['pid' => $pro['id'], 'code' => $data_arr['scode'], 'mac' => $data_arr['mac']])->find();
            // return $mac;
            //上面那行是查询有没有设备相同的
            if (!empty($mac)) {
                $run = CodeMac::where('id', $mac['id'])->update(['end_time' => time(), 'ip' => getip(), 'mac' => $data_arr['mac']]);
                if (!empty($run)) {
                    return jsons(200, $info, $pro);
                } else {
                    return jsons(199, '', $pro);
                }
            } else {
                $run = CodeMac::insert(['code' => $data_arr['scode'], 'pid' => $pro['id'], 'type' => 'scode', 'start_time' => time(), 'end_time' => time(), 'ip' => getip(), 'token' => $token, 'mac' => $data_arr['mac']]);
                if (!empty($run)) {
                    return jsons(200, $info, $pro);
                } else {
                    return jsons(199, '', $pro);
                }
            }
        } else { //此处未超过登录最大数，我们将他判定为新卡密
            return jsons(221, '', $pro);
        }
    }

    /**
     * 用户修改密码
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function changePassword($data_arr, $pro)
    {
        if (!array_key_exists('user', $data_arr)) return jsons(202, '', $pro);
        if (!array_key_exists('password', $data_arr)) return jsons(203, '', $pro);
        if (!array_key_exists('newpass', $data_arr)) return jsons(218, '', $pro);
        $user = user::where(['pid' => $pro['id'], 'user' => $data_arr['user'], 'password' => md5($data_arr['password'])])->find();
        if (empty($user)) return jsons(204, '', $pro);
        $user = user::where('id', $user['id'])->update(['password' => md5($data_arr['newpass'])]);
        if (empty($user)) {
            return jsons(199, '', $pro);
        } else {
            return jsons(200, '', $pro);
        }
    }

    /**
     * 用户充值
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function user_toup($data_arr, $pro)
    {
        $token = $data_arr['token'];
        if (empty($token)) return jsons(1025, '', $pro);
        $kami = $data_arr['kami'];
        if (empty($kami)) return jsons(1048, '', $pro);
        $res_kami = ucode::where('pid', $pro['id'])->where('kami', $kami)->find(); //false
        if (empty($res_kami)) return jsons(1049, '', $pro);
        if (!empty($res_kami['user'])) return jsons(1050, '', $pro);
        if ($res_kami['status'] == 'n') return jsons(1051, '', $pro);

        $user = plog::where('token', $token)->find();
        if (empty($user)) {
            return jsons(1075, '', $pro);
        }
        $token = user::where('pid', $user['pid'])->find();
        if (empty($token)) {
            return jsons(1027, '', $pro);
        }
        if (!empty($token['ban'])) {
            if ($token['ban'] > time() || $token['ban'] == 00000) {
                // return json($token['ban']);
                return jsons(1014, '', $pro);
            }
        }

        //  $token['vip_time'];
        if ($token['vip_time'] == 999999999) return jsons(1099, $pro);
        if ($token['ban'] > time() || $token['ban'] == 999999999) return jsons(1014, $pro);
        if ($token['vip_time'] > time()) {
            $vip = $token['vip_time'] + 86400 * $res_kami['value'];
        } else {
            $vip = time() + 86400 * $res_kami['value'];
        }
        $res = user::where('id', $token['id'])->update(['vip_time' => $vip]);
        if ($res) {
            ucode::where('id', $res_kami['id'])->update(['use_time' => time(), 'user' => $token['id']]);
            return jsons(200, '', $pro);
        } else {
            return jsons(9999, '', $pro);
        }
    }

    /**
     * 获取用户信息
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function getUserInfo($data_arr, $pro)
    {
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $res = UserMac::where(['pid' => $pro['id'], 'token' => $data_arr['token']])->find();
        if (empty($res)) {
            return jsons(214, '', $pro);
        }
        $token = $res->user;
        if (empty($token)) return jsons(214, '', $pro);
        $info = [
            'id' => $token['id'],
            'user' => $token['user'],
            'name' => $token['name'],
            'mail' => $token['mail'],
            'vip_time' => $token['vip'],
            'status' => $token['status']
        ];
        return jsons(200, $info, $pro);
    }

    /**
     * 用户签到
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function user_sgin($data_arr, $pro)
    {
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $data = UserMac::where('token', $data_arr['token'])->find();
        if (empty($data)) {
            return jsons(214, '', $pro);
        }
        $data = $data->user;
        if (empty($data)) {
            return jsons(214, '', $pro);
        }
        $res = userlog::where(['uid' => $data['id'], 'type' => '签到'])->whereBetweenTime('time', date('Y-m-d ', time()) + '00:00:00', date('Y-m-d ', time()) + '23:59:59')->find();
        $user = User::where(['pid' => $pro['id'], 'id' => $data['id']])->find();
        if (!empty($res)) return jsons(224, '', $pro);
        if ($user['vip'] == '-1') {
            userlog::insert(['uid' => $res['id'], 'type' => '签到', 'status' => 'y', 'time' => time(), 'ip' => getip(), 'pid' => $pro['id']]); //记录日志
            return jsons(200, '签到成功', $pro);
        }
        if ($user['vip'] > time()) {
            $vip = $res['vip'] + 3600 * $pro['user_sgin'];
        } else {
            $vip = time() + 3600 * $pro['user_sgin'];
        }
        $res = user::where('id', $user['id'])->update(['vip_time' => $vip]); //更新用户资料
        if (!$res) return jsons(199, '签到失败', $pro);
        userlog::insert(['uid' => $user['id'], 'type' => '签到', 'time' => time(), 'ip' => getip(), 'pid' => $pro['id']]); //记录日志
        return jsons(200, '签到成功', $pro);
    }

    /**
     * 卡密签到
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function kami_sgin($data_arr, $pro)
    {
        if (!array_key_exists('scode', $data_arr)) return jsons(206, '', $pro);
        $code = scode::where(['pid' => $pro['id'], 'kami' => $data_arr['scode']])->find();

        if (empty($code)) return jsons(207, '', $pro);
        if (empty($code['use_time'])) return jsons(227, '', $pro);
        $res = codelog::where(['code' => $data_arr['scode'], 'type' => '签到'])->whereBetweenTime('time', date('Y-m-d ', time()) + '00:00:00', date('Y-m-d ', time()) + '23:59:59')->find();
        if (!empty($res)) return jsons(224, '', $pro);
        if ($code['end_time'] == '-1') return jsons(226, '', $pro);
        if ($code['end_time'] > time()) {
            $vip = $code['end_time'] + 3600 * $pro['kami_sgin'];
        } else {
            return jsons(225, '', $pro);
        }
        $res = scode::where('id', $code['id'])->update(['end_time' => $vip]); //更新用户资料
        if (!$res) return jsons(201, '签到失败', $pro);
        codelog::insert(['code' => $code['kami'], 'type' => '签到', 'time' => time(), 'ip' => getip(), 'pid' => $pro['id']]); //记录日志
        return jsons(200, '签到成功', $pro);
    }

    /**
     * 获取单卡信息
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function getkamiInfo($data_arr, $pro)
    {
        if (!array_key_exists('scode', $data_arr)) return jsons(206, '', $pro);
        $token = scode::where('kami', $data_arr['scode'])->find();
        if (empty($token)) return jsons(207, '', $pro);
        $info = [
            'id' => $token['id'],
            'kami' => $token['kami'],
            'end_time' => $token['end_time'],
        ];
        return jsons(200, $info, $pro);
    }

    /**
     * 会员验证
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function vip_ver($data_arr, $pro)
    {
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $user = UserMac::where(['pid' => $pro['id'], 'token' => $data_arr['token']])->find();
        if (empty($user)) {
            return jsons(214, '', $pro);
        }
        $user = $user->user;
        $info = [
            'id' => $user['id'],
            'name' => $user['name'],
            'vip' => $user['vip'],
        ];
        return jsons(200, $info, $pro);
    }

    /**
     * 双卡登录
     * @param $add_res 输入内容
     * @param $pro 项目信息
     */
    function dcode_login($data_arr, $pro)
    {
        if (!array_key_exists('kami_user', $data_arr)) return jsons(228, '', $pro);
        if (!array_key_exists('kami_pass', $data_arr)) return jsons(229, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);
        $res = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->find();
        if (empty($res)) return jsons(228, '', $pro);
        if (!empty($res['mac'])) {
            if ($res['mac'] !== $data_arr['mac']) return jsons(231, '', $pro);
        }
        if (empty($res['use_time'])) {
            $time = time() + 86400 * $res['value'];
            $row = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->update(['use_time' => time(), 'mac' => $data_arr['mac'], 'end_time' => $time, 'ip' => getip()]);
            if (!$row) return jsons(9999, '登录失败', $pro);
            $info = ['kami_user' => $data_arr['kami_user'], 'end_time' => $time];
        } elseif ($res['end_time'] > time() || $res['end_time'] == '-1') {
            $info = ['kami_user' => $data_arr['kami_user'], 'end_time' => $res['end_time']];
        } else {
            return jsons(199, '登录失败双卡已过期!', $pro);
        }
        return jsons(200, $info, $pro);
    }

    /**
     * 双卡解绑
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function dcode_unbin($data_arr, $pro)
    {
        if (!array_key_exists('kami_user', $data_arr)) return jsons(229, '', $pro);
        if (!array_key_exists('kami_pass', $data_arr)) return jsons(230, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);

        $res = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->find();
        if (empty($res['use_time'])) return jsons(232, '', $pro);
        if (!empty($res['mac'])) {
            if ($res['mac'] !== $data_arr['mac']) return jsons(231, '', $pro);
        }
        $row = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->update(['mac' => null]);
        if (!$row) {
            return jsons(199, '', $pro);
        }
        return jsons(200, '', $pro);
    }

    /**
     * 双卡信息
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function dcode_info($data_arr, $pro)
    {
        if (!array_key_exists('kami_user', $data_arr)) return jsons(229, '', $pro);
        if (!array_key_exists('kami_pass', $data_arr)) return jsons(230, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);

        $res = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->find();
        if (empty($res)) return jsons(506, '', $pro);
        if (empty($res['use_time'])) return jsons(232, '', $pro);
        if (!empty($res['mac'])) {
            if ($res['mac'] !== $data_arr['mac']) return jsons(231, '', $pro);
        }
        $info = [
            'kami_user' => $res['kami_user'],
            'kami_pass' => $res['kami_pass'],
            'use_time' => $res['use_time'],
            'end_time' => $res['end_time'],
        ];
        return jsons(200, $info, $pro);
    }

    /**
     * 双卡签到 [所得到的时间是与单卡通用]
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function dcode_sgin($data_arr, $pro)
    {
        if (!array_key_exists('kami_user', $data_arr)) return jsons(229, '', $pro);
        if (!array_key_exists('kami_pass', $data_arr)) return jsons(230, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);

        $res = dcode::where(['pid' => $pro['id'], 'kami_user' => $data_arr['kami_user'], 'kami_pass' => $data_arr['kami_pass']])->find();
        if (empty($res)) return jsons(228, '', $pro);
        if ($res['end_time'] == '-1') return jsons(226, '', $pro);
        if (!$res['end_time'] > time()) {
            return jsons(225, '', $pro);
        }
        $row = codelog::where(['code' => $data_arr['kami_user'], 'value' => $data_arr['kami_pass'], 'type' => '签到'])->whereBetweenTime('time', date('Y-m-d ', time()) + '00:00:00', date('Y-m-d ', time()) + '23:59:59')->find();

        if (!empty($row)) return jsons(224, '', $pro);
        if ($res['end_time'] > time()) {
            $vip = time() + 3600 * $pro['kami_sgin'];
        }
        $res = scode::where('id', $res['id'])->update(['end_time' => $vip]); //更新用户资料
        if (!$res) return jsons(201, '签到失败', $pro);
        codelog::insert(['code' => $data_arr['kami_user'], 'value' => $data_arr['kami_pass'], 'type' => '签到', 'time' => time(), 'ip' => getip(), 'pid' => $pro['id']]); //记录日志
        return jsons(200, '签到成功', $pro);
    }

    /**
     * 单卡续费
     * 注：禁止使用，未写返回回调等功能！！！
     * 注：禁止使用，未写返回回调等功能！！！
     * 注：禁止使用，未写返回回调等功能！！！
     * 金额限制，具体看您的对接平台的限制
     * @param type 支付类型 通常仅支持 qqpay，wxpay， alipay|具体请看平台的限制以及参数
     * @param Money 金额是通过天数乘以天的价格
     */
    function scode_renew($data_arr, $pro)
    {
        // 呀~？？居然被发现了有这个功能，其实是彩蛋，目前没写
    }

    /**
     * 卡密注销
     * [卡密注销后新设备将能够登录]
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function scode_logout($data_arr, $pro)
    {
        if (!array_key_exists('scode', $data_arr)) return jsons(206, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);
        $code = scode::where(['kami' => $data_arr['scode'], 'pid' => $pro['id']])->find();
        if (empty($code)) return jsons(207, '', $pro);
        $mac = CodeMac::where(['pid' => $pro['id'], 'code' => $data_arr['scode'], 'mac' => $data_arr['mac']])->find();
        if (empty($mac)) return jsons(222, '', $pro);
        $row = CodeMac::where(['pid' => $pro['id'], 'code' => $data_arr['scode'], 'mac' => $data_arr['mac']])->delete();
        if (!empty($row)) {
            return jsons(200, '', $pro);
        } else {
            return jsons(199, '', $pro);
        }
    }

    /**
     * 用户注销 即注销爱登录设备
     * @param $data_arr 输入内容
     * @param $pro 项目信息
     */
    function user_logout($data_arr, $pro)
    {
        if (!array_key_exists('user', $data_arr)) return jsons(202, '', $pro);
        if (!array_key_exists('password', $data_arr)) return jsons(203, '', $pro);
        if (!array_key_exists('mac', $data_arr)) return jsons(205, '', $pro);

        $user = User::where(['pid' => $pro['id'], 'user' => $data_arr['user'], 'password' => md5($data_arr['password'])])->find();
        if (empty($user)) return jsons(204, '', $pro);
        $mac = UserMac::where(['pid' => $pro['id'], 'uid' => $user['id'], 'mac' => $data_arr['mac']])->delete();
        if (empty($mac)) return jsons(233, '', $pro);
        $out = UserMac::where(['pid' => $pro['id'], 'uid' => $user['id'], 'mac' => $data_arr['mac']])->delete();
        if (!empty($out)) {
            return jsons(199, '', $pro);
        } else {
            return jsons(200, '', $pro);
        }
    }

    /**
     * 项目通知列表
     * @param $data_arr 输入信息
     * @param $pro 项目的查询信息
     * @return array
     */
    function notice($data_arr, $pro)
    {
        if (!array_key_exists('nid', $data_arr)) {
            if (empty($data_arr['nid'])) {
                $list = Notice::where(['pid' => $pro['id']])->select();
            }
        } else {
            $list = Notice::where(['pid' => $pro['id'], 'id' => $data_arr['nid']])->select();
        }
        $lists = [
            'notice' => $list
        ];
        return jsons(200, $lists, $pro);
    }

    /**
     * Token更新
     * @param $data_arr 输入信息
     * @param $pro 项目的查询信息
     */
    function token_change($data_arr, $pro)
    {
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $token = UserMac::where(['pid' => $pro['id'], 'token' => $data_arr['token']])->find();
        if (empty($token)) {
            return jsons(214, '', $pro);
        }
        $user = $token->user;
        $token = getcode(32);
        $info = ['token' => $token, 'user' => $user['user']];
        $row = UserMac::where(['pid' => $pro['id'], 'token' => $data_arr['token']])->update(['token' => $token, 'end_time' => time()]);
        if (empty($row)) {
            return jsons(199, '', $pro);
        } else {
            return jsons(200, $info, $pro);
        }
    }

    /**
     * 用户消息
     * @param $data_arr 输入信息
     * @param $pro 项目的查询信息
     */
    function user_mess($data_arr, $pro)
    {
        // return $data_arr['datas'];
        if (!array_key_exists('token', $data_arr)) return jsons(213, '', $pro);
        $data = UserMac::where('token', $data_arr['token'])->find();
        if (empty($data)) {
            return jsons(214, '', $pro);
        }
        $data = Message::where('uid', $data['uid'])->select();
        $info = [
            'message' => $data
        ];
        return jsons(200, $info, $pro);
    }
}


/*
 *                        _oo0oo_
 *                       o8888888o
 *                       88" . "88
 *                       (| -_- |)
 *                       0\  =  /0
 *                     ___/`---'\___
 *                   .' \\|     |// '.
 *                  / \\|||  :  |||// \
 *                 / _||||| -:- |||||- \
 *                |   | \\\  - /// |   |
 *                | \_|  ''\---/''  |_/ |
 *                \  .-\__  '-'  ___/-. /
 *              ___'. .'  /--.--\  `. .'___
 *           ."" '<  `.___\_<|>_/___.' >' "".
 *          | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *          \  \ `_.   \_ __\ /__ _/   .-` /  /
 *      =====`-.____`.___ \_____/___.-`___.-'=====
 *                        `=---='
 * 
 * 
 *      ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * 
 *            佛祖保佑     永不宕机     永无BUG
 * 
 *              曰:  
 *                写字楼里写字间，写字间里程序员；  
 *                程序人员写程序，又拿程序换酒钱。  
 *                酒醒只在网上坐，酒醉还来网下眠；  
 *                酒醉酒醒日复日，网上网下年复年。  
 *                但愿老死电脑间，不愿鞠躬老板前；  
 *                奔驰宝马贵者趣，公交自行程序员。  
 *                别人笑我忒疯癫，我笑自己命太贱；  
 *                不见满街漂亮妹，哪个归得程序员？  
 */
