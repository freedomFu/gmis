layui.use(['element', 'table', 'layer', 'jquery','form'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$;
// $field = 'ss.id,gt.title,ss.issubmit,gs.stuidcard,stuname,stuclass,gs.stuphone';
    table.render({
        elem: '#selectStu'
        , id: 'selectStu'
        , height: 488
        , url: base_home+'/Teapply/selectStu' //数据接口
        , method: 'post'
        , cellMinWidth: 80
        , page: true //开启分页
        , cols: [[ //表头
            { field: 'kid', title: 'ID', sort: true, fixed: 'left', width: 80}
            , { field: 'title', title: '题目', width: 220}
            , { field: 'issubmit', title: '是否提交', width: 100, templet: '#isSubmitTpl' }
            , { field: 'stuidcard', title: '学生学号', width: 176 }
            , { field: 'stuname', title: '学生姓名', width: 100,  }
            , { field: 'stuclass', title: '班级', width: 120 }
            , { field: 'stuphone', title: '手机', width: 160 }
            , { align: 'center', toolbar: '#operation-bar', fixed: 'right' , width: 180 }
        ]]
    });

    $('.btn-wrap .layui-btn').on('click', function () {
        var type = $(this).data('type');
        active[type] ? active[type].call(this) : '';
    });

    table.on('tool(selectStu)', function(obj){
        var data = obj.data;
        if(obj.event === 'allow'){
            layer.confirm('确认同意么', function(index){
                layui.layer.close(index);
                var json={}
                json.id=data.id;
                console.log(json.id+"--"+data.id);
                console.log(json);
                return base_ajax(base_home+"/Teapply/chooseTitle",json,function () {
                    table.reload('selectStu', {
                        url: base_home+'/Teapply/selectStu'
                    });
                });
            });
        }
    });
})