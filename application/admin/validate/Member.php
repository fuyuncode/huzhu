<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 11:20
 */

namespace app\admin\Validate;


use think\Validate;

class Member extends Validate
{
        protected $rule = [
            ['username','require|max:11','登录名不能为空|登录名格式正确'],
            ['real_name','require|chs','姓名不能为空|姓名必须中文'],
            ['password','require|min:6','密码不能为空|密码长度不能小于6位'],
            ['safety_pwd','require|min:6','二级密码不能为空|二级密码长度不能小于6位'],
            ['Alipay','require','支付宝账号不能为空'],
            ['bank','require|chs','银行名称不能为空|银行名称格式错误'],
            ['bank_idc','require|length:16,19','银行卡号不能为空|银行卡号格式错误'],
            ['bank_ress','require|chs','开户行地址不能为空|开户行地址格式错误'],
            ['static_purse','number','静态钱包格式必须是数字'],
            ['dynamics','dynamics','动态钱包格式必须是数字'],
            ['thekey','number','排单比格式必须是数字']

        ];

}