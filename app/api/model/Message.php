<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-25 10:33:21
 * @LastEditTime : 2022-05-10 08:38:17
 * @FilePath     : \yiyanyun\app\api\model\Message.php
 */
namespace app\api\model;

use think\Model;

class Message extends Model
{
    protected $type = [
        'time' => 'timestamp'
    ];
}