<?php

//配置文件
return [
    'url_common_param'       => true,
    'url_html_suffix'        => '',
    'controller_auto_search' => true,
    'view_replace_str'      =>  [
        '__FHOME_LAYUI__'      =>  SITE_URL.'/public/fhome/layui',
    ],
];
