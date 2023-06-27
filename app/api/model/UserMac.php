<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-15 10:27:30
 * @LastEditTime: 2022-04-25 10:32:23
 * @FilePath: \yiyanyun\app\api\model\UserMac.php
 */

namespace app\api\model;

use think\Model;

class UserMac extends Model
{
    public function User()
    {
        return $this->hasOne(User::class, 'id', 'uid');
    }

    public function Message()
    {
        return $this->hasOne(Message::class,'id','uid');
    }
}
