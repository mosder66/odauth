<?php 
/*
 * @Author       : Lucifer
 * @Date         : 2022-04-10 20:27:36
 * @LastEditTime : 2022-05-09 10:12:49
 * @FilePath     : \yiyanyun\app\admin\model\Api.php
 */
namespace app\admin\model;
use think\model;

class api extends model
{
    /**
     * 设置表名
     */
    protected $table = 'yi_apicode';

    /**
     * 将时间格式化
     */
    protected $type = [
        'time'=>'timestamp'
    ];
}