<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 18:19
 */

namespace app\admin\controller;


use app\admin\model\Admin;
use think\Controller;
use think\Session;

class Login extends Controller
{

    public function index()
    {

        if (request()->isPost()) {
            $rule = [
                ['username', 'require|token', '请输入用户名!|无效的请求!'],
                ['password', 'require', '请输入密码!'],
                ['captcha|验证码', 'require|captcha'],
            ];
            $param = input('post.');
            $validate = $this->validate($param, $rule);
            if ($validate !== true) {
                return $this->error($validate, '/admin/login');
            }
            $user = new Admin();
            $result = $user->where(['username' => $param['username'], 'password' => md5($param['password'])])->find();
            if (!$result) {
                return $this->error('无效的登录信息!', '/admin/login');
            } else {
                Session::set('uid', $result->id, SESSION_ADMIN);
                Session::set('uname', $result->real_name, SESSION_ADMIN);
                Session::set('ulevel', $result->level, SESSION_ADMIN);
                $result->login_ip = request()->ip();
                $result->login_time = time();
                $result->isUpdate()->save();
                $this->redirect('/admin/index');
            }
        }
        return $this->fetch();
    }

}