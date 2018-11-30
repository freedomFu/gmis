layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$;

    table.render({
        elem: '#mySelected'
        , id: 'mySelected'
        , height: 488
        , url: base_home+'/Stuselect/mySelectedJson' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 40}
            , { field: 'title', title: '题目', width: 240}
            , { field: 'nature', title: '题目性质', width: 90 }
            , { field: 'source', title: '题目来源', width: 90 }
            , { field: 'isnew', title: '是否新题', width: 100, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 120, templet: '#isPracTpl' }
            , { field: 'weigh', title: '优先级', width: 80, edit: 'text', sort: true}
            , { field: 'status', title: '状态', width: 80 }
            , { field: 'teaname', title: '教师姓名', width: 90 }
            , { field: 'teaphone', title: '教师电话', width: 100 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 94 }
        ]]
    });

    table.render({
        elem: '#stuSelect'
        , id: 'stuSelect'
        , height: 488
        , url: base_home+'/Stuselect/showApplyTitle' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 40}
            , { field: 'title', title: '题目', width: 220}
            , { field: 'nature', title: '题目性质', width: 90 }
            , { field: 'source', title: '题目来源', width: 90 }
            , { field: 'isnew', title: '是否新题', width: 90, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 115, templet: '#isPracTpl' }
            , { field: 'status', title: '状态', width: 80 }
            , { field: 'proname', title: '专业名称', width: 140 }
            , { field: 'total', title: '已选数目', width: 90 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 174 }
        ]]
    });

    table.render({
        elem: '#myTitle'
        , id: 'myTitle'
        , height: 488
        , url: base_home+'/Stuselect/myTitleJson' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 80}
            , { field: 'title', title: '题目', width: 220}
            , { field: 'stuidcard', title: '学号', width: 140 }
            , { field: 'stuname', title: '学生姓名', width: 90 }
            , { field: 'teaname', title: '教师姓名', width: 90}
            , { field: 'replytimer', title: '答辩时间', width: 110 }
            , { field: 'replyplace', title: '答辩地点', width: 140 }
            , { field: 'replyscore', title: '答辩成绩', width: 86 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 174 }
        ]]
    });

    table.on('tool(myTitle)', function(obj) {
        var data = obj.data;
        if (obj.event === 'detail') {
            console.log('ID：'+ data.id + ' 的查看操作');
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生学号</span><span class="detailStrSpan2">'+data.stuidcard+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生姓名</span><span class="detailStrSpan2">'+data.stuname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生班级</span><span class="detailStrSpan2">'+data.stuclass+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">开题时间</span><span class="detailStrSpan2">'+data.teaname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">中期检查时间</span><span class="detailStrSpan2">'+data.starttimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩时间</span><span class="detailStrSpan2">'+data.middletimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩地点</span><span class="detailStrSpan2">'+data.replytimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">教师姓名</span><span class="detailStrSpan2">'+data.replyplace+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩成绩</span><span class="detailStrSpan2">'+data.replyscore+'</span></div>';
            layer.open({
                type: 1,
                area: ['500px', '600px'],
                shadeClose: true, //点击遮罩关闭
                content: str
            });
            $(".detailStr").css({
                "padding": "20px",
                "padding-left": "50px"

            });

            $(".detailStrSpan1").css({
                "color": "#8e8e8e",
                "font-weight": "bolder",
                "width": "70px",
                "float": "left",
                "text-align-last": "justify",
                "text-align": "justify",
                "text-justify": "distribute-all-lines", // 这行必加，兼容ie浏览器
                "font-size": "1.05em"
            });

            $(".detailStrSpan2").css({
                "font-weight": "bold",
                "color": "#1e282c",
                "margin-left": "50px"
            });
        }
    });

    table.on('tool(mySelected)', function(obj) {
        var data = obj.data;
        if (obj.event === 'del') {
            layer.confirm('确认删除么', function (index) {
                layui.layer.close(index);
                var json = {}
                json.id = data.id;
                console.log(json.id + "--" + data.id);
                return base_ajax(base_home + "/Teapply/del", json, function () {
                    table.reload('tapply', {
                        url: base_home + "/Teapply/index"
                    });
                });
            });
        }
    });

    table.on('tool(stuSelect)', function(obj) {
        var data = obj.data;
        if (obj.event === 'save') { //选题
            console.log(data.id);
            var json = {}
            json.id = data.id;
            console.log(json.id + "--" + data.id);
            return base_ajax(base_home + "/Stuselect/saveOne", json, function () {
                table.reload('stuSelect', {
                    url: base_home + "/Stuselect/showApplyTitle"
                });
            });
        } else if(obj.event === 'detail'){
            console.log('ID：'+ data.id + ' 的查看操作');
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目性质</span><span class="detailStrSpan2">'+data.nature+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目来源</span><span class="detailStrSpan2">'+data.source+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否新题</span><span class="detailStrSpan2">'+data.isnew+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否实际</span><span class="detailStrSpan2">'+data.isprac+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">状态</span><span class="detailStrSpan2">'+data.status+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">专业</span><span class="detailStrSpan2">'+data.proname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">已选数目</span><span class="detailStrSpan2">'+data.total+'</span></div>';
            layer.open({
                type: 1,
                area: ['500px', '600px'],
                shadeClose: true, //点击遮罩关闭
                content: str
            });
            $(".detailStr").css({
                "padding": "20px",
                "padding-left": "50px"

            });

            $(".detailStrSpan1").css({
                "color": "#8e8e8e",
                "font-weight": "bolder",
                "width": "70px",
                "float": "left",
                "text-align-last": "justify",
                "text-align": "justify",
                "text-justify": "distribute-all-lines", // 这行必加，兼容ie浏览器
                "font-size": "1.05em"
            });

            $(".detailStrSpan2").css({
                "font-weight": "bold",
                "color": "#1e282c",
                "margin-left": "50px"
            });
        }
    });

    // 提交数据
    $("#submit_title").click(function () {
        layer.confirm('提交后将无法修改申请，是否继续？', function (index) {
            return base_ajax(base_home + "/Carton/addCarton", null, function () {
                table.reload('carton', {
                    url: base_home + "/Carton/jsonCarton"
                });
            });
        });
    })
    //搜索
    $("#searchBtn").click(function(){
        var titlekey = $("#titlekey").val();
        var proid = $("#profess").val();
        var json = {};
        json.titlekey = titlekey;
        json.professid = proid;
        table.reload('stuSelect', {
            where: json
        });
    })



})