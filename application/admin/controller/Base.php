<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 18:11
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

class Base extends Controller
{


    protected function _initialize()
    {
        $this->verifyLogin();
        if (!$this->verifyAuth()) {
            //123
            exit(showMessage(MSG_DENY_ACCESS, MT_ERR));

        }
    }

    protected function safeOut()
    {
        Session::clear('admin');
        if (!request()->isAjax()) {
            exit($this->redirect('/admin/login'));
        } else {
            exit("redirect('/admin/login')");
        }
    }
    private function verifyLogin()
    {
        if (!$this->getUserInfo()->id && !$this->getUserInfo()->group) {
            return $this->safeOut();
        }
    }
    protected function getUserInfo()
    {
        $info = ['id' => Session::get('uid', SESSION_ADMIN), 'name' => Session::get('uname', SESSION_ADMIN), 'group' => Session::get('ulevel', SESSION_ADMIN)];
        return (object)$info;
    }
    private function verifyAuth()
    {
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        if (!request()->isAjax()) {
            if (($controller == 'index' && ($action == 'index' || $action == 'logout' || $action == 'password'))) {
                //home
            } else {
                return $this->redirect('/admin/index');
            }
        }
        if ($action == 'delete' && $this->getUserInfo()->group != '超级管理员') {
            return false;
        }

        return true;
    }


}