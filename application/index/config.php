<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/21 9:33
 * @Description: 描述信息
 */
return [
    //视图输出字符串内容替换
    'view_replace_str'      =>  [
        '__PUBLIC__'        =>  SITE_URL.'/public/home',
        '__MODULE__'        =>  SITE_URL.'/public',

        // 生成Index模块的样式模板
        '__HOME__'         =>  SITE_URL.'/public/index',
        '__HOME_CSS__'     =>  SITE_URL.'/public/home/css',
        '__HOME_JS__'      =>  SITE_URL.'/public/home/js',
    ],

    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
        'page_size' => 5, //页码数量
        'page_button'=>[
            'total_rows'=>true, //是否显示总条数
            'turn_page'=>true, //上下页按钮
            'turn_group'=>true, //上下组按钮
            'first_page'=>true, //首页
            'last_page'=>true  //尾页
        ]
    ]
];