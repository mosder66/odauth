<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-29 11:18:08
 * @FilePath: \yiyanyun\app\admin\model\Scode.php
 */
namespace app\admin\model;
use think\model;
class Scode extends model
{
    protected $type = [
        'time' => 'timestamp'
    ]; 

    public function getValueAttr($value)
    {
        $arr = [
            '-1'    =>  '永久',
            '1'     =>  '天卡',
            '7'     =>  '周卡',
            '30'    =>  '月卡',
            '365'   =>  '年卡',
        ];
        return $arr[$value];
    }
}
