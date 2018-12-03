var site_url = 'http://127.0.0.1/gmis';
var base_home = site_url+'/public/home';

layui.use(['form', 'jquery', 'layer'], function () {
    var layer = layui.layer
        , form = layui.form
        , $ = layui.$;
    var pass_layer;
    var findpass_layer;
    $("#password-btn").click(function () {//修改密码
        pass_layer=layer.open({
            type: 1,
            title: '修改密码',
            content: $('#passwordTp').html()
        });
    });
    form.on('submit(password)', function (data) {
        if (data.field.new_pass != data.field.confirm_pass) {
            layer.msg('两次密码输入不同！', {icon: 5});
            return false;
        }else{
            return base_ajax(base_home+"/User/expass", data.field, function(){
                layer.close(pass_layer);
                window.location.href=site_url+"/public/login";
            });
        }
    });

    $("#confirm_info").click(function(){
        var start = $("#start_time option:selected").text();
        var end = $("#end_time option:selected").text();
        $("#workTime").val(start+":00 - "+end+":00");

    });

    form.on('submit(add-info)', function (data) {
        return base_ajax(base_home+"/Info/set", data.field, function(){
            console.log(data);
        });
    });
});

function base_ajax(url,data,success_func){
    var $ = layui.$
        , layer = layui.layer;
    var loading = layer.msg('请稍后...',{
        icon: 16
        , shade: 0.1
        , time: 0
    });
    console.log(data);
    $.ajax({
        url: url,
        type: "post",
        data: data,
        success: function(data){
            console.log(data);
            data = JSON.parse(data);
            if(data.errno === 0 || data.status === 1||data.code===0){
                layer.close(loading);
                layer.msg(data.errmsg,{
                    icon: 1
                    , shade: 0.1
                    , time: 1000
                });
                if(success_func !== undefined){
                    success_func();
                }
            }else{
                if(data.errmsg != ""){
                    layer.msg(data.errmsg,{
                        icon: 2
                        , shade: 0.1
                        , time: 2000
                    });
                }else{
                    layer.msg("未知错误",{
                        icon: 2
                        , shade: 0.1
                        , time: 2000
                    });
                }
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            layer.msg(XMLHttpRequest.status + '提交失败', {
                icon: 2
                , shade: 0.1
                , time: 2000
            })
        },
        complete: function (XMLHttpRequest, textStatus) {
            this;
        }
    });
    return false;
}