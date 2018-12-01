$(document).ready(function() {
    $('#apply_graph input[type=checkbox]').click(function() {
            if (app.picked.length >= 3) {//选中个数大于3
                $('#apply_graph input[type=checkbox] [checked]').attr('disabled', true);
            } else {
                $('#apply_graph input[type=checkbox]').attr('disabled', false);
            }
        });
})
function tableInput(){
    $(".serial").click(function(){     
        if(!$(this).is('.input')){    
            $(this).addClass('input').html('<input type="text" style="width:100%;height:100%" value="'+ $(this).text() +'" />').find('input').focus().blur(function(){    
            var thisid = $(this).parent().siblings("th:eq(0)").text();    
            var thisvalue=$(this).val();    
            var thisclass = $(this).parent().attr("class");      
            $(this).parent().removeClass('input').html($(this).val() || "");    
            });     
        }    
        }).hover(function(){    
        $(this).addClass('hover');    
        },function(){    
        $(this).removeClass('hover');    
        })
}
tableInput();

var obj_all;
// $.ajax({
//     type: 'POST',
//     url: base_index+"/Stuselect/showApplyTitle",
//     data: {
//
//     },
//     async:false,
//     success : function(res){
//         obj_all=res.data;
//         console.log(obj_all);
//     },
//     error:function(){
//         alert("数据请求失败，请检查网络连接")
//     },
//     dataType: "json",
// });

console.log(obj_all);

var app=new Vue({
    el:"#apply",
    data:{
        store:"",
        max:5,
        newItem:{},
        picked:[],
        picked_id:[],
        searchContent:""
    },
    computed: {
        filterData: function () {  //关键字搜索
            var searchContent = this.searchContent && this.searchContent.toLowerCase()
            var items = this.store
            var items1
            if (searchContent) {
                items1 = items.filter(function (item) {
                    //console.log(Object.keys(item))
                    //return item.country.toLowerCase().match(searchContent);
                    //Object.keys(item)遍历item对象里面的键值是否符合回调函数的测试，通过测试则返回true，否则为false。
                    return Object.keys(item).some(function (key,index) {
                        if(index<3){
                            return String(item[key]).toLowerCase().match(searchContent)
                        }
                    })
                })
            } else {//searchContent为空
                items1 = this.store
            }
            return items1
        }
    },
    filters:{
        shift:function(value){   //在视图中把布尔值换为是和否
            if(value==false){
                return "否"
            }else{
                return "是"
            }
        },
    },
    methods:{
        change(index){
            console.log(this.picked)
            if(this.store[index].pick==true){  //打勾
                if(this.picked.length<3){//已选不满三个
                    console.log(app.store[index].id);
                    var id = app.store[index].id;
                    $.ajax({
                        type: 'POST',
                        url: base_index+"/Stuselect/saveOne",
                        data: {id:id},
                        success : function(res){
                            if (res.errno == 0) {  //保存成功
                                app.newItem=app.store[index];
                                app.picked.push(app.newItem);
                                app.picked_id.push(app.newItem.id)
                                app.newItem={};
                            }
                            if ((res.errno == 1) || (res.errno == 2) || (res.errno == 3) ) {
                              if(res.errmsg){
                                alert(res.errmsg);
                              }
                            }
                        },
                        error:function(){
                            alert("数据请求失败，请检查网络连接")
                        },
                        dataType: "json",
                      });
                }else{                      //已满三个
                    alert("最多只能选三个课题");
                    this.store[index].pick=false;
                }
            }else{                       //取消勾子
                console.log("取消勾");
                /*for(let i=0;i<this.picked.length;i++){
                    if(this.store[index]==this.picked[i]){
                        this.picked.splice(i,1);
                    }
                }*/
                var id = app.store[index].id;
                console.log(id);
                $.ajax({
                    type: 'POST',
                    url: base_index+"/Stuselect/delOne",
                    data: {id:id},
                    success : function(res){
                        console.log(index);
                        if (res.errno == 0) {  //删除成功
                            // alert("成功");
                            for(let i=0;i<app.picked.length;i++){
                                if(app.store[index]==app.picked[i]){
                                    app.picked.splice(i,1);
                                }
                            }
                        }
                        if (res.errno == 1) {
                            if(res.errmsg){
                                alert(res.errmsg);
                            }
                        }
                    },
                    error:function(){
                        alert("数据请求失败，请检查网络连接")
                    },
                    dataType: "json",
                });
            }
            tableInput()//给序号添加可改效果
        },
        upon(index){
            if(index>0){   //因为picked第一个是空对象
                var temp=this.picked[index-1];
                Vue.set(this.picked,index-1, this.picked[index])
                Vue.set(this.picked,index, temp)
            }
        },
        down(index){
            if(index<this.picked.length-1){
                var temp=this.picked[index+1];
                Vue.set(this.picked,index+1, this.picked[index])
                Vue.set(this.picked,index, temp)
            }
        },
        submit(){
            $.ajax({
                type: 'POST',
                url: base_index+"/Stuselect/submitData",
                data: app.picked_id,
                success : function(res){
                    if (res.errno == 0) {  //保存成功
                        alert("成功");
                        // app.newItem=app.store[index];
                        // app.picked.push(app.newItem);
                        // app.newItem={};
                    }
                    if ((res.errno == 1) || (res.errno == 2) || (res.errno == 3)) {
                        if(res.errmsg){
                            alert(res.errmsg);
                        }
                    }
                },
                error:function(){
                    alert("数据请求失败，请检查网络连接")
                },
                dataType: "json",
            });
        }

    },//end methods


    watch:{
        store(){
            this.picked=[];
            for(var i=0;i<this.store.length;i++){
                if(this.store[i].pick=="true"){
                    this.picked.push(this.store[i]);
                }
            }
        }
    }
})
$.ajax({
    type: 'POST',
    url: base_index+"/Stuselect/showApplyTitle",
    data: {

    },
    // async:false,
    success : function(res){
        app.store=res.data;
        console.log(obj_all);
    },
    error:function(){
        alert("数据请求失败，请检查网络连接")
    },
    dataType: "json",
});