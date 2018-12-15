layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$;

    // 我选择的题目
    table.render({
        elem: '#mySelected'
        , id: 'mySelected'
        , height: 488
        , url: base_home+'/Stuselect/mySelectedJson' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 35}
            , { field: 'title', title: '题目', width: 225}
            , { field: 'naturename', title: '题目性质', width: 90 }
            , { field: 'sourcename', title: '题目来源', width: 90 }
            , { field: 'isnew', title: '是否新题', width: 90, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 114, templet: '#isPracTpl' }
            , { field: 'weigh', title: '优先级', width: 80, edit: 'text', sort: true}
            , { field: 'state', title: '状态', width: 74 }
            , { field: 'teaname', title: '教师姓名', width: 90 }
            , { field: 'teaphone', title: '教师电话', width: 120 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 120 }
        ]]
    });
    //操作我选择的毕设页面
    table.on('tool(mySelected)', function(obj) {
        var data = obj.data;
        // console.log(data);
        if (obj.event === 'del') {
            layer.confirm('确认删除么', function (index) {
                layui.layer.close(index);
                var json = {}
                json.id = data.titleid;
                console.log(json.id + "--" + data.titleid);
                return base_ajax(base_home + "/Stuselect/delOne", json, function () {
                    table.reload('mySelected', {
                        url: base_home + "/Stuselect/mySelectedJson"
                    });
                });
            });
        }else if(obj.event === 'sure'){
            layer.confirm('提交后若教师选中则不能再进行操作，继续嘛？', function (index) {
                layui.layer.close(index);
                var json = {};
                json.id = data.id;
                console.log(json.id + "--" + data.id);
                return base_ajax(base_home + "/Stuselect/submitData", json, function () {
                    /*table.reload('mySelected', {
                        url: base_home + "/Stuselect/mySelectedJson"
                    });*/
                    location.reload();
                });
            });
        }
    });
    //修改权重
    table.on('edit(mySelected)', function(obj){
        var value = obj.value //得到修改后的值
            ,data = obj.data //得到所在行所有键值
            ,field = obj.field; //得到字段
        var json = {};
        json.id = data.id;
        json.weigh = value;
        console.log(json);
        return base_ajax(base_home + "/Stuselect/changeWeigh", json, function () {
            table.reload('mySelected', {
                url: base_home + "/Stuselect/mySelectedJson"
            });
            // location.reload();
        });
    });


    /*********************************************************************************************************************/
    //选择题目页面
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
            , { field: 'naturename', title: '题目性质', width: 90 }
            , { field: 'sourcename', title: '题目来源', width: 90 }
            , { field: 'isnew', title: '是否新题', width: 90, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 115, templet: '#isPracTpl' }
            , { field: 'status', title: '状态', width: 80 }
            , { field: 'proname', title: '专业名称', width: 140 }
            , { field: 'total', title: '选题人数', width: 90 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 174 }
        ]]
    });
    //操作学生选择毕设题目页面
    table.on('tool(stuSelect)', function(obj) {
        var data = obj.data;
        if (obj.event === 'save') { //选题
            console.log(data.id);
            var json = {}
            json.id = data.id;
            console.log(json.id + "--" + data.id);
            return base_ajax(base_home + "/Stuselect/saveOne", json, function () {
                /*table.reload('stuSelect', {
                    url: base_home + "/Stuselect/showApplyTitle"
                });*/
                location.reload();
            });
        } else if(obj.event === 'detail'){
            console.log('ID：'+ data.id + ' 的查看操作');
            var isnew = (data.isnew==1)?("是"):("否");
            var isprac = (data.isprac==1)?("是"):("否");
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目性质</span><span class="detailStrSpan2">'+data.naturename+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目来源</span><span class="detailStrSpan2">'+data.sourcename+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否新题</span><span class="detailStrSpan2">'+isnew+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否实际</span><span class="detailStrSpan2">'+isprac+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">状态</span><span class="detailStrSpan2">'+data.status+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">专业</span><span class="detailStrSpan2">'+data.proname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">已选数目</span><span class="detailStrSpan2">'+data.total+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">教师姓名</span><span class="detailStrSpan2">'+data.teaname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">教师电话</span><span class="detailStrSpan2">'+data.teaphone+'</span></div>';
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


    /*********************************************************************************************************************/
    //我的毕设题目页面
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
            , { field: 'replyplace', title: '答辩地点', width: 120 }
            , { field: 'middlescore', title: '中期成绩', width: 86 }
            , { field: 'replyscore', title: '答辩成绩', width: 86 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 107 }
        ]]
    });

    //操作我的毕设题目页面
    table.on('tool(myTitle)', function(obj) {
        var data = obj.data;
        if (obj.event === 'detail') {
            console.log('ID：'+ data.id + ' 的查看操作ddd');
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生学号</span><span class="detailStrSpan2">'+data.stuidcard+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生姓名</span><span class="detailStrSpan2">'+data.stuname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生班级</span><span class="detailStrSpan2">'+data.stuclass+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">开题时间</span><span class="detailStrSpan2">'+data.starttimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">中期检查时间</span><span class="detailStrSpan2">'+data.middletimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩时间</span><span class="detailStrSpan2">'+data.replytimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩地点</span><span class="detailStrSpan2">'+data.replyplace+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">教师姓名</span><span class="detailStrSpan2">'+data.teaname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">中期成绩</span><span class="detailStrSpan2">'+data.middlescore+'</span></div>';
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


    /*********************************************************************************************************************/

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