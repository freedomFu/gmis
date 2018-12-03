<?php
use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 注册路由到index模块的News控制器的read操作
Route::rule('flow','home/Pchart/index');
Route::rule('sTitle','home/Stuselect/showSelect');
Route::rule('msTitle','home/Stuselect/show');
Route::rule('mTitle','home/Stuselect/showMyTitle');
Route::rule('tApply','home/Teapply/show');
Route::rule('tSstu','home/Teapply/showSelectStu');
Route::rule('mastu','home/Reprocess/showPage');
Route::rule('myset','home/Index/showSet');
Route::rule('logout','home/User/logout');
Route::rule('login','home/Login/index');
Route::rule('index','home/Index/index');
return [
    //别名配置,别名只能是映射到控制器且访问时必须加上请求的方法
    '__alias__'   => [
    ],
    //变量规则
    '__pattern__' => [
    ],
//        域名绑定到模块
//        '__domain__'  => [
//            'admin' => 'admin',
//            'api'   => 'api',
//        ],
];
