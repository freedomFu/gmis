$(function() {
    $('.form__input').blur(function() {
      if ($(this).val().length > 0) {
        $(this).addClass('active');
      } else {
        $(this).removeClass('active');
      }
      // 判断是否 email 和 password 内容
      if ($('#username').val().length > 0 && $('#password').val().length > 0) {
        $('.form__wrapper__submit').addClass('animated');
      } else {
        $('.form__wrapper__submit').removeClass('animated');
      }
    }); 

    $(".btn_teacher").click(function(){
      var username = $("#username").val();
      var password = $("#password").val();
      var auth = 2;
      var data = {'username':username,'password':password,'auth':auth};
      var url = base_index+'/Login/login';
      var dataType = 'json';
      console.log(data);
      $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success : function(data){
            console.log("111");
            console.log(data);
            // var json=data[0];
                    if(data.success == 0){
                      alert("用户名或密码错误");
                    }
                    else if(data.success== 1){
                        window.location.href="index.html";
                    }
                },
        dataType: dataType
      });
    });
     
    $(".btn_student").click(function(){
      // $.ajax({
      //   type: 'POST',
      //   url: url,
      //   data: data,
      //   success : function(data){
      //               var json=data[0];
      //               if(json.success == 0){
      //                 alert("用户名或密码错误");
      //               }
      //               else if(json.success== 1){
      //                   window.location.href="index.html";
      //               }
      //           },
      //   dataType: dataType
      // });
      // window.URL=
    });



    
  })//end ready
