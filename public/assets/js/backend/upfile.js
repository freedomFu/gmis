define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'upfile/index',
                    add_url: 'upfile/add',
                    edit_url: 'upfile/edit',
                    del_url: 'upfile/del',
                    multi_url: 'upfile/multi',
                    table: 'upfile',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'filename', title: "下载文件", operate: "LIKE"},
                        {field: 'fileext', title: __('Fileext'),visible:false},
                        {field: 'belongsenior', title: __('Belongsenior')},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3'),"4":__('Type 4')}, formatter: Table.api.formatter.normal},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'filepath', title: "下载文件", formatter: function(value){
                                var link = value;
                                var path = "<a href='javascript:void(0)' onclick='javascript:window.location.href=\""+link+"\"'><i class='glyphicon glyphicon-save'></i></a>";
                                return path;
                        }},
                        {field: 'process.stuid', title: __('Process.stuid'), visible:false, operate:false},
                        {field: 'process.teaid', title: __('Process.teaid'), formatter: Table.api.formatter.search},
                        {field: 'process.teaname', title: "教师姓名", operate:false},
                        {field: 'process.stuname', title: "学生姓名", operate:false},
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