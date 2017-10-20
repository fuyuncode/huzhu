<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/18
 * Time: 18:03
 */

namespace app\admin\controller;

use app\admin\model\Member as modelMember;
use think\console\command\make\Model;

class Member extends Base
{


    public function index()
    {


        return $this->fetch('index');

    }


    public function view()
    {
        $member = new modelMember();
        if (request()->isAjax() && request()->isPost()) {
            $count = $member->count();
            $list = $member->select();
            $data = ['code' => 0, 'msg' => '', 'count' => $count, 'data' => $list];
            return json_encode($data);
        }

        if (input('?page') && input('?limit')) {
            $showby = input('limit');
            $start = intval(input('page') - 1) * $showby;
            if (input('?filter')) {
                $filtes = input('filter');
                $count = $member->where('username|real_name', 'like', '%' . $filtes . '%')->count();
                $list = $member->where('username|real_name', 'like', '%' . $filtes . '%')->limit($start, $showby)->select();
            } else {
                $count = $member->count();
                $list = $member->limit($start, $showby)->select();
            }

            $data = ['code' => 0, 'msg' => '', 'count' => $count, 'data' => $list];
            return json_encode($data);
        }
    }


    public function add()
    {
        $member = new modelMember();
        $param = input('post.');

        if (!empty($param['pid'])) {
            $res = $member->where('username', $param['pid'])->find();
            if ($res)
                $param['pid'] = $res->id;
            else
                return showMessage('推荐人不存在', 2);
        }

        $result = $member->allowField(true)->validate(true)->save($param);


        if ($result) {
            return showMessage('操作成功', 1, "function(){loadData('/admin/member');}");
        } else {

            return showMessage($member->getError(), 2);
        }


    }

    public function blocked($id)
    {
        if (request()->isAjax() && request()->isPost()) {
            $object = new modelMember;
            $obj = $object->where('id', $id)->find();
            if ($obj->blocked == '是') {
                $obj->blocked = 0;
            } else {

                $obj->blocked = 1;
            }
            $result = $obj->isUpdate()->save();
            if ($result) {
                return $obj->blocked;
            } else {
                return 'error';
            }
        }


    }

    public function detail($id)
    {


        return $this->fetch('detail', ['id' => $id]);

    }

    public function detail_view($id)
    {


        $showby = input('limit');
        $start = intval(input('page') - 1) * $showby;
        $object = new modelMember();
        $member = $object->field('id,pid')->limit(500)->select();
        $count = $object->where('pid', $id)->count();
        if ($count > 0) {
            foreach ($member as $value) {
                if ($value['pid'] == $id) {
                    //idc 获取一级推荐人id
                    $idc[] = $value['id'];
                }
                //获取所有存在pid的用户
                if ($value['pid']) {
                    $ids[] = $value['id'];
                    $pids[] = $value['pid'];
                }
            }

            //所有数据合并 //c的key为所有用户的id,值id对应的pid;
            $c = array_combine($ids, $pids);
//       for ($i =0;$i<count($idc);$i++){
            //获取第二代
            $result = array_intersect($idc, $c);
            if ($result) {
                for ($i = 0; $i < 3; $i++) {
//            while (true) {
                    foreach ($result as $k => $v) {
                        //$v = 有推荐关系的下级ID
                        foreach ($c as $key => $a) {
                            if ($v == $a) {
//                            $ids[] = $key;
                                $idcs[] = $key;
                            }
                        }
                    }
                    $result = array_intersect($idcs, $c);
                }
            }


//            dump($result);

//          while (true){
//
//
//
//
//          }
//       }
//            //获取一级推荐人的最后一个ID
//            $end = end($idc);
//            //判断是否有下级
//            $k = array_search($end, $c);
//            if ($k) {
//                while (true) {
//                    //循环合并的数据 $key 用户id $a用户对应pid
//                    foreach ($c as $key => $a) {
//                        //获取二级被推荐人ID
//                        if ($a == $end) {
//                            $q[] = $key;
//                            $idc[] = $key;
//                        }
//                    }
//                    $end = end($q);
//                    $e = array_search($end, $c);
//                    if ($e === false) {
//                        break;
//                    }
//                }
//            }
//            dump($idc);
            $list = $object->where('pid', $id)->limit($start, $showby)->select();
        } else {
            $list = array();
        }
        $data = ['code' => 0, 'msg' => '', 'count' => $count, 'data' => $list];
        return json_encode($data);

    }

}