<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-27 08:13:30
 * @LastEditTime : 2022-05-08 19:24:24
 * @FilePath     : \yiyanyun\app\admin\model\UserLog.php
 */
namespace app\admin\model;

use think\Model;

class UserLog extends Model
{
    protected $type = [
        'time' => 'timestamp'
    ];
}