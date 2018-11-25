$(function() {
    $("#teacher").click(function(){
      $.ajax({
        type: 'POST',
        url: base_index+"/Login/login",
        data: {
          "auth":2,
          "username":$("#username").val(),
          "password":$("#password").val(),
        },
        success : function(res){
          // docCookies.setItem("user", "一个靓仔", new Date(2222, 2, 2), "../");
            console.log(res);
            if (res.errno == 0) {  //登陆成功
                alert("登录成功");
                window.location.href=base_index+"/Index/index"
            }
            if (res.errno == 1) {  //账号或者密码错误
                alert("账号或者密码错误");
            }
            if (res.errno == 2) {  //登陆方式非法
                alert("登陆方式非法，请重新选择登陆方式");
            }
        },
        error:function(){
            alert("数据请求失败，请检查网络连接")
        },
        dataType: "json",
      });
    });

    $("#student").click(function(){
      $.ajax({
        type: 'POST',
        url: base_index+"/Login/login",
        data: {
          "auth":1,
          "username":$("#username").val(),
          "password":$("#password").val(),  
        },
        success : function(res){
          // docCookies.setItem("user", "一个靓仔", new Date(2222, 2, 2), "../");
            if (res.errno == 0) {  //登陆成功
                alert("登录成功");
                window.location.href=base_index+"/Index/index"
            }
            if (res.errno == 1) {  //账号或者密码错误
                alert("账号或者密码错误");
            }
            if (res.errno == 2) {  //登陆方式非法
                alert("登陆方式非法，请重新选择登陆方式");
            }
        },
        error:function(){
            alert("数据请求失败，请检查网络连接")
        },
        dataType: "json",
      });
    });
  })//end ready

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