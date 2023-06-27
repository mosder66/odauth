<?php
/*
 * @Author: Lucifer
 * @Date: 2022-04-10 20:27:36
 * @LastEditTime: 2022-04-30 14:49:44
 * @FilePath: \yiyanyun\app\admin\model\Dcode.php
 */

namespace app\admin\model;

use think\model;

class dcode extends model
{
    /**
     * 将时间戳格式化后再输出
     */
    protected $type = [
        'time' => 'timestamp'
    ];

    /**
     * 卡密面值转换
     */
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
