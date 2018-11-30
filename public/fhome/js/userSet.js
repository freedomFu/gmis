layui.use(['element', 'table', 'layer', 'jquery','form','layedit','laydate'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$,
        layedit = layui.layedit,
        laydate = layui.laydate;

    //日期
    laydate.render({
        elem: '#starttimer'
    });
    laydate.render({
        elem: '#middletimer'
    });
    laydate.render({
        elem: '#replytimer'
    });

    form.on('submit(change_info)', function(data){//更新设置
        return base_ajax(base_home+"/Index/changeInfo",data.field,function () {
            console.log(data);
        });
    });

})