layui.use(['element', 'table', 'layer', 'jquery','form','layedit','laydate'], function () {
    var form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$;



    table.render({
        elem: '#title'
        ,url:base_adjust+'/Adjust/getTitleList'
        ,width: 600
        ,cols: [[
            {type:'radio'}
            ,{field:'kid', width:60, title: 'ID', sort: true, align: 'center'}
            ,{field:'title', width:245, title: '题目名称', align: 'center'}
            ,{field:'teaname', width:120, title: '教师姓名', align: 'center'}
            ,{field:'teaphone', width:120, title: '教师电话', align: 'center'}
        ]]
        ,page: true
    });

    table.render({
        elem: '#stu'
        ,url:base_adjust+'/Adjust/getStuList'
        ,width: 600
        ,cols: [[
            {type:'radio'}
            ,{field:'kid', width:60, title: 'ID', sort: true, align: 'center'}
            ,{field:'stuname', width:100, title: '学生姓名', align: 'center'}
            ,{field:'stuidcard', width:145, title: '学号', align: 'center'}
            ,{field:'stuclass', width:120, title: '班级', align: 'center'}
            ,{field:'stuphone', width:120, title: '电话', align: 'center'}
        ]],
        page:true
    });
    $("#manual_adjust").click(function () {
        var title = table.checkStatus("title");
        var stu = table.checkStatus("stu");
        if(title.data.length==0 || stu.data.length==0){
            layer.msg('请选中后操作', {icon: 5});
            return false;
        }else{
            var json = {};
            json.stuid = stu.data[0].id;
            json.titleid = title.data[0].id;
            console.log(json);
            return base_ajax(base_adjust+"/Adjust/upData", json, function(){
                table.reload('stu', {
                    url: base_adjust+'/Adjust/getStuList'
                });
                table.reload('title', {
                    url: base_adjust+'/Adjust/getTitleList'
                });
            });
        }
    });

    $("#prior_adjust").click(function () {
        return base_ajax(base_adjust+"/Adjust/pa", null, function(){

        });
    });

    $("#default_adjust").click(function () {
        return base_ajax(base_adjust+"/Adjust/da", null, function(){

        });
    });



})