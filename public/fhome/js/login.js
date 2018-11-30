layui.use(['form','jquery','layer'],function(){
    var $ = layui.$
        , layer = layui.layer
        , form = layui.form;
    //登录
    form.on('submit(userLog)',function(data){
        return base_ajax(base_home+"/Login/login",data.field,function(){
            window.location.href=base_home+"/Index/index";
        });
    });
});