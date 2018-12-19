layui.use(['element', 'table', 'layer', 'jquery','form','layedit','laydate'], function () {
    var element = layui.element,
        form = layui.form,
        layer = layui.layer,
        table = layui.table,
        $ = layui.$,
        laydate = layui.laydate;

    // 获取当前学年      2018.9 - 2019.8 为 2019
    function getSeniorYear(){
        //获取当前年月
        var date = new Date;
        var year = date.getFullYear();
        var lastyear = year-1;
        var nextyear = year+1;
        var month  = date.getMonth();
        if(month > 9){
            return nextyear;
        }else{
            return year;
        }
    }
    //获取年份   格式都是2018-10-23
    function getYear(time){
        return time.substr(0,4);
    }
    //获取月份
    function getMonth(time){
        return time.substr(5,2);
    }
    //检查时间是否合格
    function checkTime(time){
        var inyear = getYear(time);
        var inmonth = getMonth(time);
        var now = getSeniorYear();
        if(((inyear==now)&&(inmonth<9)) || ((inyear==now-1)&&(inmonth>9))){
            return true;
        }else{
            return false;
        }
    }

    function checkRank(){
        var stime = $("#starttimer").val();
        var mtime = $("#middletimer").val();
        var rtime = $("#replytimer").val();

        if(stime>mtime || mtime>rtime || stime>rtime){
            return false;
        }else{
            return true;
        }
    }

    function changeColor(idname){
        var time = $(idname).val();
        if(!checkTime(time)){
            $(idname).css("color","red");
            layer.msg('请修改变红的地方', {
                icon: 5,
                time: 2000 //2秒关闭（如果不配置，默认是3秒）
            });
        }else{
            $(idname).css("color","black");
        }

    }

    /*********************************************************/
    function checkChange() {
        var stimeid = "#starttimer";
        var mtimeid = "#middletimer";
        var rtimeid = "#replytimer";
        changeColor(stimeid);
        changeColor(mtimeid);
        changeColor(rtimeid);
    }

    checkChange();

    /*********************************************************/

    //日期
    laydate.render({
        elem: '#starttimer'
    });
    laydate.render({
        elem: '#middletimer'
    });
    laydate.render({
        elem: '#replytimer'
    });


    form.verify({
        belongtime: function(value,item){
            //判断月份
            if(!checkTime(value)){
                return '请填写符合当前学年的时间！';
            }
        },
        checkrank: function(value, item){
            if(!checkRank()){
                return '请填写符合顺序的时间！';
            }
        }
    });

    form.on('submit(change_info)', function(data){//更新设置
        return base_ajax(base_home+"/Index/changeInfo",data.field,function () {
            checkChange();
            console.log(data);
        });
    });

})