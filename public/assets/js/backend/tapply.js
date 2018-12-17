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
            //,formatter:Table.api.formatter.toggle
            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'title', title: __('Title')},
                        {field: 'nature', title: __('Nature'), formatter:function(value){
                                switch (value){
                                    case "1":
                                        return "A：工程设计、产品开发";
                                        break;
                                    case "2":
                                        return "B：工程技术研究";
                                        break;
                                    case "3":
                                        return "C：软件开发设计";
                                        break;
                                    case "4":
                                        return "D：理论性研究、调查报告、案例分析";
                                        break;
                                    case "5":
                                        return "E：其它";
                                        break;
                                    default:
                                        return "未知";
                                }
                            }},
                        {field: 'source', title: __('Source'), formatter:function(value){
                                switch (value){
                                    case "1":
                                        return "A：自然科学基金与省、部、市级以上科研课题";
                                        break;
                                    case "2":
                                        return "B：企、事业单位委托课题";
                                        break;
                                    case "3":
                                        return "C：校级基金课题";
                                        break;
                                    case "4":
                                        return "D：自拟课题";
                                        break;
                                    default:
                                        return "未知";
                                }
                            }},
                        {field: 'isnew', title: __('Isnew'),formatter:function(value){
                                if(value == 1){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }},
                        {field: 'isprac', title: __('Isprac'),formatter:function(value){
                                if(value == 1){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }},
                        {field: 'profess.proname', title: __('Profess.proname')},
                        {field: 'student.stuidcard', title: __('Student.stuidcard'),visible:false},
                        {field: 'student.stuname', title: __('Student.stuname')},
                        {field: 'student.stuclass', title: __('Student.stuclass'),visible:false},
                        {field: 'student.stuphone', title: __('Student.stuphone'),visible:false},
                        {field: 'teacher.teaname', title: __('Teacher.teaname')},
                        {field: 'proid', title: __('Proid'),visible:false,operate:false},
                        {field: 'note', title: __('Note'),operate:false},
                        {field: 'stuid', title: __('Stuid'),visible:false,operate:false},
                        {field: 'belongsenior', title: __('Belongsenior')},
                        {field: 'teaid', title: __('Teaid'),visible:false,operate:false},
                        {field: 'weigh', title: __('Weigh'),visible:false,operate:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime,visible:false,operate:false},
                        {field: 'status', title: __('Status'), searchList: {"已通过":__('已通过'),"未通过":__('未通过')}, yes: '已通过', no: '未通过',formatter: Table.api.formatter.toggle},

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