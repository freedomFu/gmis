
$(function(){           
    
    
    function tableInput(){
        $(".revisable").click(function(){     
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
            $('.NO').unbind();
    }
    tableInput()

}); 


var app=new Vue({
    el:"#apply",
    data:{
        newBook:{
            a1:"",
            title:"",
            nature:"",
            source:"",
            isNew:true,
            isAllow:true,
            a7:"",
            a8:"",
            a9:"",
            a10:"",
            a11:"",
            a12:"",
        },
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
            a10:"name",
            a11:"2017",
            a12:"18889509377",
        },{
            a1:"啊啊啊啊啊",
            title:"",
            nature:"",
            source:"",
            isNew:false,
            isAllow:true,
            a7:"",
            a8:"",
            a9:"",
            a10:"",
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
            a10:"",
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
            a10:"",
            a11:"",
            a12:"",
        },],
        max:5,
        
    },
    methods:{
        add:function(){
            if(this.store.length>=this.max){
                alert("您可申请题目为"+this.max+"个。")
                return;
            }
            this.store.push(this.newBook);
            this.newBook={a1:"",a2:"",a3:"", a4:"", a5:"", a6:"",a7:"", a8:"",a9:"",a10:"", a11:"",a12:""}
        },
        del:function(index){
            this.store.splice(index,1)
        },
    
    }
})




var pre=new Vue({
    el:"#pre",
    data:{
        page:[true,false],
        nowPage:2,
        data2d:testData,
        },   //end data
    methods:{
        turnTo:function(i){ //i从1开始
            this.nowPage=i;
        },
        pre:function(){
            if(this.nowPage>1){
                this.nowPage-=1;
            }
        },
        next:function(){
            if(this.nowPage<this.page.length){
                this.nowPage+=1;
            }
        },
        isNear:function(index){
            if(index<=(this.nowPage-5)  || index>=(this.nowPage+5) ){
                return false;
            }else{
                return true;
            }
        }
    },
    watch:{
        nowPage:function(newVal,oldVal){
            $('#operation li').eq(oldVal).removeClass("active");
            $('#operation li').eq(newVal).addClass("active");
            for(var i=0;i<this.data2d.length;i++){
                Vue.set(this.page, i, false)
            }
            Vue.set(this.page,newVal-1, true)
            for(var i=0;i<this.page.length;i++){
            }
        }   
    }
            
     
    
})