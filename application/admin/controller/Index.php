<?php
namespace app\admin\controller;
use think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 16:26
 */
class Index extends Base
{

    public function index()
    {


        return $this->fetch();

    }
    public function info()
    {
        $os = [php_uname('s'), php_uname('r')];
        return $this->fetch('info', [
            'os1' => implode(' ', $os),
            'os2' => php_uname('v'),
            'ver' => PHP_VERSION,
            'ip' => GetHostByName(request()->server('SERVER_NAME')),
            'time' => date('Y-m-d H:i:s', time()),
            'evv' => request()->server('SERVER_SOFTWARE'),
            'user' => Get_Current_User(),
            'zend' => Zend_Version(),
            'cip' => request()->ip()
        ]);
    }
    public function logout()
    {
        return $this->safeOut();
    }

}