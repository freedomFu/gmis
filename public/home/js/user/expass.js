$("#expass").click(function(){
    var oldPwd=$("#old_password").val();
    var newPwd=$("#new_password").val();
    var conPwd=$("#new_password2").val();
    if( newPwd!=conPwd ){
        alert("两次密码输入不一致");
    }else{
        $.ajax({
            type: 'POST',
            url: base_index+"/User/expass",
            async:false,
            data: {
                "oldPwd":oldPwd,
                "newPwd":newPwd,
                "conPwd":conPwd,
            },
            success : function(res){
                if (res.errno == 0) {  //修改成功
                    alert("修改成功，您可以使用新密码登录");
                    window.location.href=base_index+"/Login/index"
                }
                if (res.errno == 1) {  //密码修改失败，请重试
                    alert("修改失败");
                }
                if (res.errno == 2) {  //原密码错误
                    alert("原密码错误");
                }
                if (res.errno == 3) {  //两次输入密码不一致
                    alert("两次输入密码不一致");
                }
                if (res.errno == 4) {  //密码输入不规范
                    alert("密码输入不规范");
                }
                if (res.errno == 4) {  //未知错误
                    alert("未知错误");
                }
            },
            error:function(){
                alert(111);
                alert("数据请求失败，请检查网络连接");
            },
            dataType: "json",
        });
    }
});

function findSuccess(){
    $("#find").hide();
    $("#success").show();
}
