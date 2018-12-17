define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

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

            //当表格数据加载完成时
            table.on('load-success.bs.table', function (e, data) {
                //这里可以获取从服务端获取的JSON数据
                console.log(data);
                //这里我们手动设置底部的值
                $("#totalnum").text(data.extend.totalnum);
            });


            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                pageSize: 50,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'teaidcard', title: __('Teaidcard')},
                        {field: 'teaname', title: __('Teaname')},
                        {field: 'teapwd', title: __('Teapwd'),visible:false},
                        {field: 'teaduty', title: __('Teaduty'), searchList: {"一岗":__('一岗'),"二岗":__('二岗'),"三岗":__('三岗'),"四岗":__('四岗'),"五岗":__('五岗'),"六岗":__('六岗'),"七岗":__('七岗'),"八岗":__('八岗'),"九岗":__('九岗'),"十岗":__('十岗'),"其它":__('其它')}, formatter: Table.api.formatter.normal},
                        {field: 'teahonor', title: __('Teahonor'), searchList: {"教授":__('教授'),"副教授":__('副教授'),"讲师":__('讲师'),"助教":__('助教'),"正高级实验师":__('正高级实验师'),"高级实验师":__('高级实验师'),"实验师":__('实验师'),"助理实验师":__('助理实验师'),"实验员":__('实验员')}, formatter: Table.api.formatter.normal},
                        {field: 'teatitlenum', title: __('Teatitlenum')},
                        {field: 'teaphone', title: __('Teaphone')},
                        {field: 'teabelongid', title: __('Teabelongid')},
                        {field: 'starttimer', title: __('Starttimer')},
                        {field: 'middletimer', title: __('Middletimer')},
                        {field: 'replytimer', title: __('Replytimer')},
                        {field: 'replyplace', title: __('Replyplace')},
                        {field: 'note', title: __('Note')},
                        {field: 'weigh', title: __('Weigh'),visible:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false},
                        {field: 'status', title: __('Status'), searchList: {"任教中":__('任教中'),"未任教":__('未任教')}, formatter: Table.api.formatter.status},
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