layui.use(['element', 'table', 'layer', 'jquery','form','upload'], function () {
    var $ = layui.$,
        upload = layui.upload;

    //开题报告
    upload.render({
        elem: '#openreport'
        , url: base_home + '/Stuselect/upopreport'
        , accept: 'file' //普通文件
        , size: 8000
        , exts: 'doc|docx|pdf' //只允许上传word和pdf
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
            location.reload();
        }
        , error: function (index, upload) {
            layer.closeAll('loading'); //关闭loading
        }
    });
    //毕设论文
    upload.render({
        elem: '#mypaper'
        , url: base_home + '/Stuselect/upmypaper'
        , accept: 'file' //普通文件
        , size: 8000
        , exts: 'doc|docx|pdf' //只允许上传word和pdf
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
            location.reload();
        }
        , error: function (index, upload) {
            layer.closeAll('loading'); //关闭loading
        }
    });

    //毕设材料
    upload.render({
        elem: '#mycode'
        , url: base_home + '/Stuselect/upmycode'
        , accept: 'file' //普通文件
        , size: 8000
        , exts: 'zip|rar|7z' //只允许上传word和pdf
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
            location.reload();
        }
        , error: function (index, upload) {
            layer.closeAll('loading'); //关闭loading
        }
    });
})