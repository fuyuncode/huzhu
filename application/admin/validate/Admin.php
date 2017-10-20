<?php


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 21:40
 */
namespace app\admin\Validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['username', 'require|min:5', '用户名不能为空|用户名必须大于等于5位'],
        ['password', 'require|min:6', '请输入密码|密码不能少于6个字符'],
        ['real_name', 'require|chs|max:6', '请输入管理员姓名|管理员姓名必须是中文|管理员姓名格式错误']

    ];

}