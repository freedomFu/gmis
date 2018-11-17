define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'tapply/index',
                    add_url: 'tapply/add',
                    edit_url: 'tapply/edit',
                    del_url: 'tapply/del',
                    multi_url: 'tapply/multi',
                    table: 'tapply',
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
                        {field: 'title', title: __('Title')},
                        {field: 'nature', title: __('Nature')},
                        {field: 'source', title: __('Source')},
                        {field: 'isnew', title: __('Isnew')},
                        {field: 'isprac', title: __('Isprac')},
                        {field: 'proid', title: __('Proid')},
                        {field: 'note', title: __('Note')},
                        {field: 'stuid', title: __('Stuid')},
                        {field: 'teaid', title: __('Teaid')},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"已通过":__('已通过'),"未通过":__('未通过')},yes: '已通过', no: '未通过', formatter: Table.api.formatter.toggle},
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