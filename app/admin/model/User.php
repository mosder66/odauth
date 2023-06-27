<?php
/*
 * @Author       : Lucifer
 * @Date         : 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 15:08:15
 * @FilePath     : \yiyanyun\app\admin\model\User.php
 */

namespace app\admin\model;

use think\model;

class User extends model
{
    protected $type = [
        'reg_time' => 'timestamp'
    ];
}
