<?php
// 这是系统自动生成的公共文件

/**
 * @param code msg 代码
 * @param msg 如果为空则使用msg库
 * @param pro 项目信息数组 控制返回值加密类型
 * @return {"code":200,"msg":"msg提示信息","time":"服务器返回时间","sgin":"信息签名"}
 */
function jsons($code, $msg = null, $pro = null)
{
    if ($msg && is_array($msg) && isset($msg['mi_state']) && isset($msg['mi_type'])) {
        $msg = null;
    }
    if (!$msg && !is_array($msg)) {
        $msg = msg($code);
    }
    $sgin = sign_md5($pro);
    if (empty($msg)) {
        $data = array('code' => $code, 'explain' => $msg, 'time' => time(), 'sgin' => $sgin);
    } else {
        $data = array('code' => $code, 'explain' => $msg, 'time' => time(), 'sgin' => $sgin);
    }
    $data = json_encode($data);
    if ($pro['encrypt'] == '1') {
        return $data = openssl_encrypt($data, 'AES-128-ECB', $pro['key_aes'], 0); //aes加密
    } elseif ($pro['encrypt'] == '2') {
        $data = base64_encode($data);
    }
    echo $data;
    exit;
}


/**
 * 数字代码对应留言
 * @param int code 
 * @return str msg[]
 */
function msg($code)
{
    $msg = [
        '197' => '未发现加密数据包',
        '198' => '已关闭该方式',
        '199' => '未知原因失败',
        '200' => '操作成功',
        '201' => '已关闭当前方式登录',
        '202' => '请输入账号',
        '203' => '请输入密码',
        '204' => '账号或密码有误',
        '205' => '设备码为空',
        '206' => '卡密为空',
        '207' => '卡密不存在',
        '208' => '卡密已被绑定',
        '209' => '卡密已到期',
        '210' => '卡密解绑成功',
        '211' => '卡密签到成功',
        '212' => '卡密未被使用',
        '213' => 'Token为空',
        '214' => 'Token不存在',
        '215' => '卡密已被禁用',
        '216' => '卡密使用失败',
        '217' => '账号已存在',
        '218' => '请输入新密码',
        '219' => '请输入天数',
        '220' => '请输入类型',
        '221' => '卡密登录设备已上限制',
        '222' => '未查询到卡密信息中登录有该设备',
        '223' => '账号所登录的设备已上限',
        '224' => '今日已签到',
        '225' => '卡密到期禁止签到',
        '226' => '永久卡禁止签到',
        '227' => '卡密未使用',
        '228' => '双卡不存在',
        '229' => '请输入双卡号',
        '230' => '请输入双卡密',
        '231' => '请使用原设备登录',
        '232' => '卡密未使用',
        '233' => '账号未在设备中登录',
        '234' => '接口已关闭',
        '235' => '项目已关闭',
        '236' => '签名值为空',
    ];
    return $msg[$code];
}
/**
 * MD5加密签名
 * @param array $data[]
 */
function sign_md5($data = [])
{
    if (!is_array($data)) { // 数据类型检测
        $data = (array) $data;
    } // 排序
    ksort($data); // url编码并生成query字符串
    $code = http_build_query($data);
    $sign = md5($code); // 生成签名
    return $sign;
}


/**
 * 取随机字符
 * @param int Str::length($value)
 * @return str
 */
function getcode($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $max = strlen($strPol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

/**
 * 获取客户端IP
 * @return int 0.0.0.0
 */
function getip()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknow")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknow")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknow")) {
        $ip = getenv("REMOTE_ADDR");
    } else if (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknow")) {
        $ip = $_SERVER["REMOTE_ADDR"];
    } else {
        $ip = "unknow";
    }
    return $ip;
}

/**
 * 解密结果转数组
 * @param txt 需要转换的值
 * @return array 返回数组
 */
function txt_Arr($txt){//文本转数组
    $arr = explode('&', $txt);
    $array = [];
    foreach($arr as $value){
        $tmp_arr = explode('=',$value);
        if(is_array($tmp_arr) && count($tmp_arr) == 2){
            $array = array_merge($array,[$tmp_arr[0]=>$tmp_arr[1]]);
        }
    }
    return $array;
}