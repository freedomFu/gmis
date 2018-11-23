define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'process/index',
                    add_url: 'process/add',
                    edit_url: 'process/edit',
                    del_url: 'process/del',
                    multi_url: 'process/multi',
                    table: 'process',
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
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'tapply.title', title: __('Tapply.title')},
                        {field: 'titleid', title: __('Titleid'),visible:false,operate:false},
                        {field: 'student.stuidcard', title: __('Student.stuidcard')},
                        {field: 'student.stuname', title: __('Student.stuname')},
                        {field: 'student.stuclass', title: __('Student.stuclass')},
                        {field: 'stuid', title: __('Stuid'),visible:false,operate:false},
                        {field: 'teaid', title: __('Teaid'),visible:false,operate:false},
                        {field: 'teacher.starttimer', title: __('Teacher.starttimer')},
                        {field: 'teacher.middletimer', title: __('Teacher.middletimer')},
                        {field: 'teacher.replytimer', title: __('Teacher.replytimer')},
                        {field: 'teacher.replyplace', title: __('Teacher.replyplace')},
                        {field: 'replyscore', title: __('Replyscore')},
                        {field: 'belongsenior', title: __('Belongsenior')},
                        {field: 'weigh', title: __('Weigh'),visible:false,operate:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
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