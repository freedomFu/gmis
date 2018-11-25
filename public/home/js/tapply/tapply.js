// function fresh(){
var obj_apply;
var obj_stu;
$.ajax({   //请求      教师申请表格的数据
    type: 'POST',
    url: base_index+"/Teapply/index",
    data: {},
    async:false,
    success : function(res){
        console.log(res);
        obj_apply=res;
        console.log(obj_apply);
    },
    error:function(){
        alert("数据请求失败，请检查网络连接!")
    },
    dataType: "json",
  });

$.ajax({    //请求      学生毕设管理表格的数据
    type: 'POST',
    url: base_index+"/Reprocess/show",
    data: {},
    async:false,
    success : function(res){
        console.log(res);
        obj_stu=res;
        console.log(obj_stu);
    },
    error:function(){
        alert("数据请求失败，请检查网络连接!")
    },
    dataType: "json",
});
// }

// fresh()

var app=new Vue({
    el:"#apply_teacher",
    data:{
        editing:[],
        store:obj_apply.data,
        newItem:{
            id:"",
            nature:"",
            source:"",
            isnew:"",
            isprac:"",//是否结合实践
            proid:"",//专业名称
            isallow:false,
            note:"",//备注
            status:"状态",
            stuidcard:"",//学生号
            stuname:"",//姓名
            stuclass:"",//班级
            stuphone:"",//电话

        },
        count:obj_apply.count,     //可申请总数
        left:obj_apply.left,//剩余可申请数量
        old_item:{}

    },
    created: function () {
        for(var i=0;i<this.store.length;i++){
            this.editing.push(false)
        }
    },
    methods:{
        add:function(){
            if(this.store.length>=this.count){
                alert("您可申请题目为"+this.count+"个。")
                return;
            }
            this.newItem.id=this.store.length+1;
            $.ajax({
                type: 'POST',
                url: base_index+"/Teapply/add",
                data: this.newItem,
                success : function(res){
                    alert(res.errmsg);
                },
                error:function(){
                    alert("数据发送失败，请检查网络连接")
                },
                dataType: "json",
              });
            
            this.store.push(this.newItem);
            this.newItem={
                id:this.store.length+1,
                title:"",
                nature:"",
                source:"",
                isnew:"",
                isprac:"",//是否结合实践
                proname:"",//专业名称
                isallow:true,
                note:"",//备注
                status:"",
                stuidcard:"",//学生号
                stuname:"",//姓名
                stuclass:"",//班级
                stuphone:"",//电话
            }
            readyNumber()

        },
        del:function(index){
            if(confirm("确认删除？")){
                var s = this.store;
                $.ajax({
                    type: 'POST',
                    url: base_index+"/Teapply/del",
                    data: s[index],
                    success : function(res){
                        console.log(s);
                        console.log(index);
                        if(res.errno==0){
                            s.splice(index,1);
                        }
                        alert(res.errmsg);
                    },
                    error:function(){
                        alert("数据发送失败，请检查网络连接")
                    },
                    dataType: "json",
                });
            }
        },
        edit:function(index){
            this.old_item=this.store[index];
            console.log(this.old_item)
            var aim_textarea="#mytable tr:eq("+(index+1)+") textarea";
            var aim_input="#mytable tr:eq("+(index+1)+") input";
            var aim_select="#mytable tr:eq("+(index+1)+") select";
            Vue.set(this.editing, index, true)
            $(aim_input).removeAttr("disabled");
            $(aim_textarea).removeAttr("disabled");
            $(aim_select).removeAttr("disabled");
        },
        sure:function(index){
            var aim_input="#mytable tr:eq("+(index+1)+") textarea";
            var aim_textarea="#mytable tr:eq("+(index+1)+") input";
            var aim_select="#mytable tr:eq("+(index+1)+") select";
            Vue.set(this.editing, index, false)
            $(aim_input).attr("disabled","disabled");
            $(aim_textarea).attr("disabled","disabled");
            $(aim_select).attr("disabled","disabled");
            console.log(this.store);
            var s = this.store;
            $.ajax({
                type: 'POST',
                url: base_index+"/Teapply/edit",
                data: s[index],
                success : function(res){
                    console.log(s);
                    alert(res.errmsg);
                },
                error:function(){
                    alert("数据发送失败，请检查网络连接")
                },
                dataType: "json",
              });
        },
        submitApply:function(){
            $.ajax({
                type: 'POST',
                url: "http://localhost/gmis/public/index/Reprocess/show",
                data: {
                    
                },
                success : function(res){
                    obj_apply=res.data;
                },
                error:function(){
                    alert("数据请求失败，请检查网络连接")
                },
                dataType: "json",
              });
        }
    }
})

function readyNumber() { 
      $('textarea').each(function () {
         this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
      }).on('input', function () {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
      })
    }
    
    readyNumber()


var stu=new Vue({
    el:"#apply_stu",
    data:{
        store:obj_stu.data,
        count:obj_stu.count,
        editing:[false,false]
    },
    methods:{
        edit:function(index){

            if(this.store[index].replyscore=="0"){
                var aim_input="#apply_graph2 tr:eq("+(index+1)+") input";
                Vue.set(this.editing, index, true)
                $(aim_input).removeAttr("disabled");
                $("#apply_graph2 tr").eq(index+1).addClass("success");
            }
        },
        sure:function(index){
            var aim_input="#apply_graph2 tr:eq("+(index+1)+") textarea";
            var aim_textarea="#apply_graph2 tr:eq("+(index+1)+") input";
            console.log(aim_input)
            Vue.set(this.editing, index, false)
            $(aim_input).attr("disabled","disabled");
            $(aim_textarea).attr("disabled","disabled");
            $("#apply_graph2 tr").eq(index+1).removeClass("success")
            var s = this.store;
            $.ajax({
                type: 'POST',
                url: base_index+"/Reprocess/editScore",
                data: s[index],
                success : function(res){
                    console.log(s[index]);
                    console.log(res);
                    alert(res.errmsg);
                },
                error:function(){
                    alert("数据发送失败，请检查网络连接");
                },
                dataType: "json",
              });
        },
    }
})