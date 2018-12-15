define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'sselect/index',
                    add_url: 'sselect/add',
                    edit_url: 'sselect/edit',
                    del_url: 'sselect/del',
                    multi_url: 'sselect/multi',
                    table: 'sselect',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'stuid', title: __('Stuid'), visible:false},
                        {field: 'titleid', title: __('Titleid'), visible:false},
                        {field: 'teaid', title: __('Teaid'), visible:false},
                        {field: 'student.stuname', title: __('Student.stuname')},
                        {field: 'student.stuclass', title: __('Student.stuclass')},
                        {field: 'student.stuphone', title: __('Student.stuphone')},
                        {field: 'tapply.title', title: __('Tapply.title')},
                        {field: 'teacher.teaname', title: __('Teacher.teaname')},
                        {field: 'teacher.teaphone', title: __('Teacher.teaphone')},
                        {field: 'pick', title: __('Pick'),formatter:function(value){
                                if(value == "true"){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }},
                        {field: 'isallow', title: __('Isallow'),formatter:function(value){
                                if(value == 1){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }},
                        {field: 'issubmit', title: __('Issubmit'),formatter:function(value){
                                if(value == 1){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }},
                        {field: 'belongSenior', title: __('Belongsenior')},
                        {field: 'weigh', title: __('Weigh'), visible:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime, visible:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime, visible:false},
                        {field: 'status', title: __('Status'), searchList: {"正常":__('正常'),"隐藏":__('隐藏')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});