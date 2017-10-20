<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/17
 * Time: 20:32
 */

namespace app\admin\controller;


use think\Controller;
use app\admin\model\Admin;

class User extends Base
{
    public function index()
    {


        return $this->fetch('index', ['info' => $this->getUserInfo()]);

    }

    public function add()
    {
        $user = new Admin();

        if (request()->isPost() && request()->isAjax()) {
            if ($this->getUserInfo()->group != '超级管理员'){
                return showMessage(MSG_DENY_ACCESS, MT_ERR);
            }
            $param = input('post.');

            $result = $user->where('username', $param['username'])->whereOr('real_name')->find();
            if ($result) {
                return showMessage(MSG_ERR_DATA_EXISTS, MT_ERR);
            }
            $insert = $user->allowField(true)->validate(true)->save($param);
            if ($insert) {
                return showMessage('添加成功', 1, "function(){loadData('/admin/user');}");
            } else {
                return showMessage($user->getError(), 2);
            }
        }


    }

    public function view()
    {
        $admin = new Admin();
        $list = $admin->field('password', true)->select();
        $count = $admin->count();
        $data = ['code' => 0, 'msg' => "", 'count' => $count, 'data' => $list];
        $list = json_encode($data);
        return $list;
    }

    public function edit($id)
    {
        $admin = new Admin();
        $obj = $admin->where('id', $id)->find();
        if ($this->getUserInfo()->group == '超级管理员') {
            $this->assign('data', $obj);
        } elseif ($obj->id == $this->getUserInfo()->id) {
            $this->assign('data', $obj);
        } else {
            $this->error(MSG_DENY_ACCESS, 'admin/user');
        }
        return $this->fetch();
    }
    public function update()
    {

        if (request()->isAjax() && request()->isPost())
        {
            $param=input('post.');
            $user = new Admin();
            $result = $user->isUpdate()->validate(true)->save($param);

            if ($result){
                return showMessage('操作成功', 1, "function(){loadData('/admin/user');}");
            }else{
                return showMessage($user->getError(), 2);
            }
        }


    }
    public function delete()
    {
        if (request()->isPost()) {
            $id = input('post.id');
            if ($id && Admin::destroy($id)) {
                return $this->pageURL();
            } else {
                return showMessage(MSG_ERR_DEL_FAILED, MT_ERR);
            }
        }
    }

    protected function pageURL()
    {
        echo "loadData('/admin/user');";
    }

}