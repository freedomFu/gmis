layui.use(['element', 'table', 'layer', 'jquery','form','upload'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$,
        upload = layui.upload,
        layer_change,
        layer_assign;

    table.render({
        elem: '#showStudent'
        , id: 'showStudent'
        , height: 488
        , url: base_home+'/Reprocess/show' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 60}
            , { field: 'title', title: '题目', width: 180, templet: '#titleTpl'}
            , { field: 'stuidcard', title: '学号', width: 130}
            , { field: 'stuname', title: '姓名', width: 75 }
            , { field: 'stuclass', title: '班级', width: 100,  }
            , { field: 'replytimer', title: '答辩时间', width: 104 }
            , { field: 'replyplace', title: '答辩地点', width: 100 }
            , { field: 'middlescore', title: '中期成绩', width: 100 }
            , { field: 'replyscore', title: '答辩成绩', width: 100 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 180 }
        ]]
    });

    $('.btn-wrap .layui-btn').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on('tool(showStudent)', function(obj){
        var data = obj.data;
        if(obj.event === 'detail'){
            console.log('ID：'+ data.id + ' 的查看操作');
            var str = '<div class="detailStr"><span class="detailStrSpan1">题目</span><span class="detailStrSpan2">'+data.title+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学号</span><span class="detailStrSpan2">'+data.stuidcard+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">学生姓名</span><span class="detailStrSpan2">'+data.stuname+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">班级</span><span class="detailStrSpan2">'+data.stuclass+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">开题时间</span><span class="detailStrSpan2">'+data.starttimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">中期时间</span><span class="detailStrSpan2">'+data.middletimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩时间</span><span class="detailStrSpan2">'+data.replytimer+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">答辩地点</span><span class="detailStrSpan2">'+data.replyplace+'</span></div>';
            str += '<div class="detailStr"><span class="detailStrSpan1">备注</span><span class="detailStrSpan2">'+data.note+'</span></div>';
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
        }else if(obj.event === 'edit'){
            layer.confirm('确认进行该操作么', function(index){
                layui.layer.close(index);
                var json={}
                json.id=data.id;
                console.log(json.id+"--"+data.id+"--"+data['middlescore']+"--"+data['replyscore']);
                layer_change=layer.open({
                    type: 1,
                    title: '修改成绩',
                    area: ['420px', '300px'],
                    content: $('#changeScore'),
                });

                form.val("changeScore", {
                    "id": data['id']
                    ,"mscore": data['middlescore']
                    ,"rscore": data['replyscore']
                })
            });
        }else if(obj.event === 'upfile'){ //上传任务书
            layer.confirm('您可以反复提交，以最新的为准！请谨慎操作！', function(index) {
                layui.layer.close(index);
                var json = {}
                json.id = data.id;
                layer_assign = layer.open({
                    type: 1,
                    title: '上传任务书',
                    area: ['240px', '150px'],
                    content: $('#up_assign'),
                });

                //上传任务书，只允许word文档类型的
                /************************************************************************/

                upload.render({
                    elem: '#upassign'
                    , url: base_home + '/Teapply/upassign'
                    , accept: 'file' //普通文件
                    , size: 8000
                    , exts: 'doc|docx|pdf' //只允许上传word和pdf
                    , data: json
                    , before: function (obj) { //obj参数包含的信息，跟 choose回调完全一致，可参见上文。
                        layer.load(); //上传loading
                    }
                    , done: function (res) {
                        layer.closeAll('loading'); //关闭loading
                        if (res.errno == 0) {
                            layer.msg(res.errmsg, {icon: 1, time: 2000});
                        } else {
                            layer.msg(res.errmsg, {icon: 5, time: 2000});
                        }
                        layer.close(layer_assign);
                        location.reload();
                    }
                    , error: function (index, upload) {
                        layer.closeAll('loading'); //关闭loading
                    }
                });
            });

            /************************************************************************/
        }
    });

    form.on('submit(change_score)', function(data){//修改成绩

        return base_ajax(base_home+"/Reprocess/editScore",data.field,function () {
            table.reload('showStudent', {
                url: base_home+"/Reprocess/show"
            });
            layer.close(layer_change);
        });
    });


})