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

// 这是系统自动生成的公共文件

// use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

/**
 * 重构json
 * @param code 状态码
 * @param msg 说明文
 * @param time 时间戳
 */
function jsons($code = 200, $msg = '')
{
    header('Content-type: application/json');
    $data['code'] = $code;
    $data['msg'] = $msg;
    $data['time'] = time();
    $rsult = json_encode($data, true);
    echo $rsult;
    exit;
}

/**
 * 客户端IP地址获取
 * @return 1.1.1.1
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
 * 获取一串字符串[其实和下方的key_code是差不多得到只是多了一个长度选择]
 * @param int $length 字符串获取的长度
 * @param bool $case true为大小写混一起，false为全部为大写
 */
function get_code($length, $case = true)
{
    $str = null;
    $strpol = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghizklmnopqrstuvwsyz0123456789";
    $max = strlen($strpol) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str .= $strpol[rand(0, $max)];
    }
    // 判断是否是输出大小写格式
    if ($case == true) {
        return $str;
    } else {
        return strtoupper($str);
    }
}

/**
 * 获取一串字符串
 * @return str
 */
function key_code()
{
    $str = md5(uniqid(md5(microtime(true)), true));
    $str = sha1($str); //加密
    return $str;
}
