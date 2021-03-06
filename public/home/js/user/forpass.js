$(function() {
    $("#teacher").click(function(){
        $.ajax({
            type: 'POST',
            url: base_index+"/Login/findpass",
            data: {
                "auth":2,
                "useremail":$("#email").val(),
                "id":$("#username").val(),
            },
            success : function(res){
                // docCookies.setItem("user", "一个靓仔", new Date(2222, 2, 2), "../");
                if (res.errno == 0) {  //登陆成功
                    alert("找回成功，请查看邮箱");
                    window.location.href=base_index+"/Login/index"
                }
                if (res.errno == 1) {  //各项不可为空
                    alert("各项不可为空");
                }
                if (res.errno == 2) {  //邮箱不符合规范
                    alert("邮箱不符合规范");
                }
                if (res.errno == 3) {  //找回失败
                    alert("找回失败");
                }
                if (res.errno == 4) {  //未知错误
                    alert("未知错误");
                }
            },
            error:function(){
                alert("数据请求失败，请检查网络连接")
            },
            dataType: 'json',
        });
    });

    $("#student").click(function(){
        $.ajax({
            type: 'POST',
            url: base_index+"/Login/findpass",
            data: {
                "auth":1,
                "useremail":$("#email").val(),
                "id":$("#username").val(),
            },
            success : function(res){

                // docCookies.setItem("user", "一个靓仔", new Date(2222, 2, 2), "../");

                if (res.errno == 0) {  //找回成功
                    alert("找回成功，请查看邮箱");
                    window.location.href=base_index+"/Login/index"
                }
                if (res.errno == 1) {  //各项不可为空
                    alert("各项不可为空");
                }
                if (res.errno == 2) {  //邮箱不符合规范
                    alert("邮箱不符合规范");
                }
                if (res.errno == 3) {  //找回失败
                    alert("找回失败");
                }
                if (res.errno == 4) {  //未知错误
                    alert("未知错误");
                }
            },
            error:function(){
                alert("数据请求失败，请检查网络连接")
            },
            dataType: 'json',
        });
    });
})//end ready

function findSuccess(){
    $("#find").hide();
    $("#success").show();
}

var docCookies = {
    getItem: function (sKey) {
        return decodeURIComponent(document.cookie.replace(new RegExp("(?:(?:^|.*;)\\s*" + encodeURIComponent(sKey).replace(/[-.+*]/g, "\\$&") + "\\s*\\=\\s*([^;]*).*$)|^.*$"), "$1")) || null;
    },
    setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
        if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) { return false; }
        var sExpires = "";
        if (vEnd) {
            switch (vEnd.constructor) {
                case Number:
                    sExpires = vEnd === Infinity ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT" : "; max-age=" + vEnd;
                    break;
                case String:
                    sExpires = "; expires=" + vEnd;
                    break;
                case Date:
                    sExpires = "; expires=" + vEnd.toUTCString();
                    break;
            }
        }
        document.cookie = encodeURIComponent(sKey) + "=" + encodeURIComponent(sValue) + sExpires + (sDomain ? "; domain=" + sDomain : "") + (sPath ? "; path=" + sPath : "") + (bSecure ? "; secure" : "");
        return true;
    },
    removeItem: function (sKey, sPath, sDomain) {
        if (!sKey || !this.hasItem(sKey)) { return false; }
        document.cookie = encodeURIComponent(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" + ( sDomain ? "; domain=" + sDomain : "") + ( sPath ? "; path=" + sPath : "");
        return true;
    },
    hasItem: function (sKey) {
        return (new RegExp("(?:^|;\\s*)" + encodeURIComponent(sKey).replace(/[-.+*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
    },
    keys: /* optional method: you can safely remove it! */ function () {
        var aKeys = document.cookie.replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "").split(/\s*(?:\=[^;]*)?;\s*/);
        for (var nIdx = 0; nIdx < aKeys.length; nIdx++) { aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]); }
        return aKeys;
    }
};