<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/18
 * Time: 15:08
 */

namespace app\admin\controller;

use app\admin\model\Config as CfgModel;
use think\Validate;

class Config extends Base
{
    public function index()
    {
        if (request()->isAjax() && request()->isPost()){
            $config = new CfgModel();

            if ($this->getUserInfo()->group == '超级管理员') {

                $result = $config->isUpdate()->save(input('post.'));
                if ($result) {
                    return 'success';
                } else {
                    return 'error';
                }
            }else{
                return MSG_DENY_ACCESS;
            }
        }
        return $this->fetch('index',['level'=>$this->getUserInfo()->group]);
    }

    public function view()
    {
        $list = CfgModel::all();
        $data=['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
        return json_encode($data);

    }

    public function add()
    {
        $config = new CfgModel();
        if (request()->isAjax() && request()->isPost()) {
            $param = input('post.');
            $validate = new Validate(['cfg_name' => 'require|chs', 'cfg_val' => 'require','per'=>'require'], ['cfg_name.require' => '配置名不能为空', 'cfg_name.chs' => '配置名必须中文','cfg_val.require'=>'值不能为空','per.require'=>'单位不能为空']);
            $result = $validate->check($param);
            if ($result === false){
                return showMessage($validate->getError(),MT_ERR);
            }
            if ($config->save($param)){
                return showMessage('操作成功',MT_SUCCESS,"function(){loadData('/admin/config');}");
            }

        }
    }


}