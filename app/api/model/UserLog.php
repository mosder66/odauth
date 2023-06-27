<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-16 21:13:55
 * @FilePath: \yiyanyun\app\api\model\UserLog.php
 */
namespace app\api\model;
use think\model;

class UserLog extends model
{
    public function User()
    {
        return $this->hasOne(User::class,'id');
    }
}