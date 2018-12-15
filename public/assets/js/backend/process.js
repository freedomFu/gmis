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
                        {field: 'id', title: __('Id')},
                        {field: 'titleid', title: __('Titleid'), visible:false},
                        {field: 'stuid', title: __('Stuid'), visible:false},
                        {field: 'teaid', title: __('Teaid'), visible:false},
                        {field: 'tapply.title', title: __('Tapply.title')},
                        {field: 'student.stuname', title: __('Student.stuname')},
                        {field: 'student.stuclass', title: __('Student.stuclass')},
                        {field: 'student.stuphone', title: __('Student.stuphone')},
                        {field: 'teacher.teaname', title: __('Teacher.teaname')},
                        {field: 'teacher.teaphone', title: __('Teacher.teaphone')},
                        {field: 'teacher.starttimer', title: __('Teacher.starttimer')},
                        {field: 'teacher.middletimer', title: __('Teacher.middletimer')},
                        {field: 'teacher.replytimer', title: __('Teacher.replytimer')},
                        {field: 'teacher.replyplace', title: __('Teacher.replyplace')},
                        {field: 'middlescore', title: __('Middlescore'), searchList: {"优":__('优'),"良":__('良'),"中":__('中'),"通过":__('通过'),"不通过":__('不通过'),"未填写":__('未填写')}, formatter: Table.api.formatter.normal},
                        {field: 'replyscore', title: __('Replyscore'), searchList: {"优":__('优'),"良":__('良'),"中":__('中'),"通过":__('通过'),"不通过":__('不通过'),"未填写":__('未填写')}, formatter: Table.api.formatter.normal},
                        {field: 'belongsenior', title: __('Belongsenior')},
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