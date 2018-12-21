var site_url = 'http://127.0.0.1/gmis';
var base_adjust = site_url+'/public/admin';

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