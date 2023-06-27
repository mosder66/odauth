<?php 
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-26 15:32:21
 * @FilePath: \yiyanyun\app\admin\model\Project.php
 */
namespace app\admin\model;
use think\model;
class Project extends model
{
    protected $type = [
        'time' => 'timestamp'
    ];
    
    public function encrypt($data)
    {
        $type = [
            0=>'不加密',
            1=>'AES-128-ECB',
            2=>'BASE64'
        ];
        return $type[$data['type']];
    }
}