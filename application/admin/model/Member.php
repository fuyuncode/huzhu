<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 10:54
 */

namespace app\admin\model;


use think\Model;

class Member extends Model
{

    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $type = [
        'add_time' => 'timestamp',
        'login_time' => 'timestamp'
    ];

    public function getBlockedAttr($value)
    {
        $arr = ['否', '是'];
        return $arr[$value];
    }

    public function setPasswordAttr($value)
    {
        $value = trim($value);
        return strlen($value) > 0 ? md5($value) : $value;
    }

    public function setSafetyPwdAttr($value)
    {
        $value = trim($value);
        return strlen($value) > 0 ? md5($value) : $value;

    }
}