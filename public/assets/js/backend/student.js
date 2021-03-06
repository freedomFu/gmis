define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'student/index',
                    add_url: 'student/add',
                    edit_url: 'student/edit',
                    del_url: 'student/del',
                    import_url: 'student/import',
                    multi_url: 'student/multi',
                    table: 'student',
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
                        {field: 'stuidcard', title: __('Stuidcard')},
                        {field: 'stupwd', title: __('Stupwd'),visible:false,operate:false},
                        {field: 'stuname', title: __('Stuname')},
                        {field: 'stuclass', title: __('Stuclass')},
                        {field: 'stuphone', title: __('Stuphone')},
                        {field: 'profess.proname', title: __('Profess.proname')},
                        {field: 'stuproid', title: __('Stuproid'),visible:false,operate:false},
                        {field: 'weigh', title: __('Weigh'),visible:false,operate:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'status', title: __('Status'), searchList: {"应届生":__('应届生'),"其他":__('其他')}, formatter: Table.api.formatter.status},
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