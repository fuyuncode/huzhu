<?php
namespace app\admin\model;
use think\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 21:07
 */
class Admin extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $type = [
        'login_time' => 'timestamp',
    ];

    public function getLevelAttr($value)
    {
        $arr = ['超级管理员', '普通管理员'];
        return $arr[$value];
    }

    public function setPasswordAttr($value)
    {
        $value = trim($value);
        return strlen($value) > 0 ? md5($value) : $value;
    }

}