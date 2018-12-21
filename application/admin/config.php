<?php

//配置文件
return [
    'url_common_param'       => true,
    'url_html_suffix'        => '',
    'controller_auto_search' => true,
    'view_replace_str'      =>  [
        '__ADJUST_LAYUI__'      =>  SITE_URL.'/public/assets/adjust/layui',
        '__ADJUST_JS__'      =>  SITE_URL.'/public/assets/adjust/js',
        '__ADJUST_CSS__'      =>  SITE_URL.'/public/assets/adjust/css',
        '__ADJUST_PUBLIC__'      =>  SITE_URL.'/public/admin/Adjust/',
    ],
];
