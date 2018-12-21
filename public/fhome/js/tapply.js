layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$,
        layer_tapply,
        layer_change;

    function getNum(){
        $.ajax({
            url: base_home+"/Teapply/index",
            type: "post",
            success: function(data){
                console.log(data);
                data = JSON.parse(data);
                var left = data.left;
                var total = data.total;
                if(left==0){
                    $("#add_tapply_check").addClass("layui-hide");
                }else{
                    $("#add_tapply_check").removeClass("layui-hide");
                    $("#add_tapply_check").addClass("layui-btn");
                }
                console.log(left);
                $("#totalNum").html(total);
                $("#leftNum").html(left);
            },
        });
    }

    getNum();

    table.render({
        elem: '#tapply'
        , id: 'tapply'
        , height: 488
        , url: base_home+'/Teapply/index' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 80}
            , { field: 'title', title: '题目', width: 200}
            , { field: 'naturename', title: '题目性质', width: 90 }
            , { field: 'sourcename', title: '题目来源', width: 90 }
            , { field: 'isnew', title: '是否新题', width: 100, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 120, templet: '#isPracTpl' }
            , { field: 'proname', title: '专业', width: 190 }
            , { field: 'status', title: '状态', width: 80 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 174 }
        ]]
    });

    table.render({
        elem: '#told'
        , id: 'told'
        , height: 488
        , url: base_home+'/Teapply/told' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 120}
            , { field: 'title', title: '题目', width: 200}
            , { field: 'naturename', title: '题目性质', width: 100 }
            , { field: 'sourcename', title: '题目来源', width: 100 }
            , { field: 'isnew', title: '是否新题', width: 100, templet: '#isNewTpl' }
            , { field: 'isprac', title: '是否结合实践', width: 120, templet: '#isPracTpl' }
            , { field: 'proname', title: '专业', width: 200 }
            , { field: 'status', title: '状态', width: 190 }
        ]]
    });

    //搜索
    $("#searchBtn").click(function(){
        var year = $("#oldyear").val();
        var json = {};
        json.year = year;
        table.reload('told', {
            where: json
        });
    })


    var $ = layui.$, active = {
        new: function () {
            layer_tapply=layer.open({
                type: 1,
                title: '申请题目',
                content: $('#apply_title').html()
            });
            form.render();
        }
    };

    $('.btn-wrap .layui-btn').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });
    table.on('tool(tapply)', function(obj){
        var data = obj.data;
        if(obj.event === 'del'){
            layer.confirm('确认删除么', function(index){
                layui.layer.close(index);
                var json={}
                json.id=data.id;
                console.log(json.id+"--"+data.id);
                return base_ajax(base_home+"/Teapply/del",json,function () {
                    /*table.reload('tapply', {
                        url: base_home+"/Teapply/index"
                    });*/
                    // getNum();
                    location.reload();
                });
            });
        } else if(obj.event === 'edit'){
            layer.confirm('确认进行该操作么', function(index){
                layui.layer.close(index);
                layer_change=layer.open({
                    type: 1,
                    title: '修改信息',
                    content: $('#editShow')
                });
                var isnew = (data['isnew']==1)?true:false;
                var isprac = (data['isprac']==1)?true:false;
                console.log(isnew+'--'+isprac);
                console.log(data['nature']+'--'+data['source']);
                form.val("editShow", {
                    "id": data['id']
                    ,"title": data['title']
                    ,"nature": data['nature']
                    ,"source": data['source']
                    ,"proid": data['proid']
                    ,"isnew": isnew
                    ,"isprac": isprac
                })
            });
        } else if(obj.event === 'detail'){
            console.log('ID：'+ data.id + ' 的查看操作');
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目性质</span><span class="detailStrSpan2">'+data.naturename+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">题目来源</span><span class="detailStrSpan2">'+data.sourcename+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否新题</span><span class="detailStrSpan2">'+data.isnew+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">是否实际</span><span class="detailStrSpan2">'+data.isprac+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">专业</span><span class="detailStrSpan2">'+data.proname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">备注</span><span class="detailStrSpan2">'+data.note+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">状态</span><span class="detailStrSpan2">'+data.status+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生号</span><span class="detailStrSpan2">'+(data.stuidcard==null?"-":data.stuidcard)+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生名</span><span class="detailStrSpan2">'+(data.stuname==null?"-":data.stuname)+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">班级</span><span class="detailStrSpan2">'+(data.stuclass==null?"-":data.stuclass)+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">电话</span><span class="detailStrSpan2">'+(data.stuphone==null?"-":data.stuphone)+'</span></div>';
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

    form.on('submit(apply_title)', function(data){//申请题目

        if(data.field.isnew == "on") {
            data.field.isnew = "1";
        } else {
            data.field.isnew = "0";
        }
        if(data.field.isprac == "on") {
            data.field.isprac = "1";
        } else {
            data.field.isprac = "0";
        }

        return base_ajax(base_home+"/Teapply/add",data.field,function () {
            table.reload('tapply', {
                url: base_home+"/Teapply/index"
            });
            getNum();
            layer.close(layer_tapply);
        });
    });

    form.on('submit(change_apply)', function(data){//修改申请
        console.log("测试");

        if(data.field.isnew == "on") {
            data.field.isnew = "1";
        } else {
            data.field.isnew = "0";
        }
        if(data.field.isprac == "on") {
            data.field.isprac = "1";
        } else {
            data.field.isprac = "0";
        }

        return base_ajax(base_home+"/Teapply/edit",data.field,function () {
            table.reload('tapply', {
                url: base_home+"/Teapply/index"
            });
            layer.close(layer_change);
        });
    });
})