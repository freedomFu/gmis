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
tableInput()



var app=new Vue({
    el:"#apply",
    data:{
        store:[{
            a1:"",
            title:"陈泽旺帅的一逼",
            nature:"好",
            source:"原创",
            isNew:true,
            isAllow:false,
            a7:"",
            a8:"",
            a9:"num",
            pick:false,
            a11:"2017",
            a12:"18889509377",
        },{
            a1:"",
            title:"",
            nature:"",
            source:"",
            isNew:false,
            isAllow:true,
            a7:"",
            a8:"",
            a9:"",
            pick:false,
            a11:"",
            a12:"",
        },{
            a1:"",
            title:"",
            nature:"",
            source:"",
            isNew:true,
            isAllow:false,
            a7:"",
            a8:"",
            a9:"",
            pick:false,
            a11:"",
            a12:"",
        },{
            a1:"",
            title:"",
            nature:"",
            source:"",
            isNew:false,
            isAllow:true,
            a7:"",
            a8:"",
            a9:"",
            pick:false,
            a11:"",
            a12:"",
        },],
        max:5,
        newItem:{},
        picked:[{}
        
        ,]
    },
    methods:{
        change(index){
            console.log("打勾")
            console.log(this.picked)
            if(this.store[index].pick==true){  //打勾
                if(this.picked.length<=3){//已选不满三个
                    this.newItem=this.store[index];
                    this.picked.push(this.newItem);
                    newItem={};
                }else{                      //已满三个
                    alert("最多只能选三个课题");
                    this.store[index].pick=false;
                }
            }else{                       //取消勾子
                console.log("取消勾")
                for(let i=0;i<this.picked.length;i++){
                    if(this.store[index]==this.picked[i]){
                        this.picked.splice(i,1);
                    }
                }
            }
            tableInput()//给序号添加可改效果
        },
        upon(index){
            if(index>1){   //因为picked第一个是空对象
                var temp=this.picked[index-1];
                Vue.set(this.picked,index-1, this.picked[index])
                Vue.set(this.picked,index, temp)
            }
        },
        down(index){
            if(index<3){
                var temp=this.picked[index+1];
                Vue.set(this.picked,index+1, this.picked[index])
                Vue.set(this.picked,index, temp)
            }
        }   
    },
    watch:{
       
        
    }
})

