define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    Form.api.bindevent("form[role=form]");
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'teacher/index',
                    add_url: 'teacher/add',
                    edit_url: 'teacher/edit',
                    del_url: 'teacher/del',
                    multi_url: 'teacher/multi',
                    table: 'teacher',
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
                        {field: 'teaidcard', title: __('Teaidcard')},
                        {field: 'teaname', title: __('Teaname')},
                        {field: 'teapwd', title: __('Teapwd'),visible:false,operate:false},
                        {field: 'teaduty', title: __('Teaduty')},
                        {field: 'teahonor', title: __('Teahonor'), searchList: {"助教":__('助教'),"讲师":__('讲师'),"副教授":__('副教授'),"教授":__('教授')},formatter: Table.api.formatter.status},
                        {field: 'teatitlenum', title: __('Teatitlenum')},
                        {field: 'starttimer', title: __('Starttimer')},
                        {field: 'middletimer', title: __('Middletimer')},
                        {field: 'replytimer', title: __('Replytimer')},
                        {field: 'replyplace', title: __('Replyplace')},
                        {field: 'note', title: __('Note'),visible:false},
                        {field: 'weigh', title: __('Weigh'),visible:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'status', title: __('Status'), searchList: {"任教中":__('任教中'),"未任教":__('未任教')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

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