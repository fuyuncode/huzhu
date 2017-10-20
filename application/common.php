<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
define('MT_ERR', 2);
define('MT_SUCCESS', 1);
define('MT_WARINING', 0);
define('MT_INFO', 3);
define('SESSION_ADMIN', 'admin');
define('MSG_DENY_ACCESS', '您没有权限执行此操作');
define('MSG_ERR_DATA_EXISTS', '数据已存在');
define('MSG_ERR_DEL_FAILED', '删除数据失败');
function showMessage($content, $message = MT_SUCCESS, $func = null)
{
    if ($func) {
        echo "showMessage('{$content}','{$message}',$func)";
    } else {
        echo "showMessage('{$content}','{$message}')";
    }
}