layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$,
        layer_change;

    table.render({
        elem: '#showStudent'
        , id: 'showStudent'
        , height: 488
        , url: base_home+'/Reprocess/show' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 80}
            , { field: 'title', title: '题目', width: 180}
            , { field: 'stuidcard', title: '学号', width: 150}
            , { field: 'stuname', title: '姓名', width: 100 }
            , { field: 'stuclass', title: '班级', width: 100,  }
            , { field: 'replytimer', title: '答辩时间', width: 120 }
            , { field: 'replyplace', title: '答辩地点', width: 120 }
            , { field: 'replyscore', title: '成绩', width: 100 }
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
                console.log(json.id+"--"+data.id);
                layer_change=layer.prompt({
                    formType: 0,
                    value: data.replyscore,
                    title: '输入成绩',
                    area: ['800px', '350px'] //自定义文本域宽高
                }, function(value, index, elem){
                    console.log(data.replyscore);
                    console.log(elem);
                    json.replyscore = value;
                    return base_ajax(base_home+"/Reprocess/editScore",json,function () {
                        table.reload('showStudent', {
                            url: base_home+"/Reprocess/show"
                        });
                        layer.close(index);
                    });
                });
            });
        }
    });
})