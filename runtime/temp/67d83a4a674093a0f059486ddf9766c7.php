<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"C:\wamp64\www\gmis\public/../application/index\view\tapply\teacher.html";i:1543241900;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>教师管理毕设题目</title>
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/home/css/tapply.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="apply">
    <div id="apply_teacher">
        <h4 id="apply_remind" >
            <span>2019</span>
            <span>届 毕设题目申请（您可申请题目为<span>{{count}}</span>个，请填写备注之前信息）</span>
        </h4>
        <div id="apply_graph">
            <table id="mytable"  class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <th>序号</th>
                <th>题目</th>
                <th>课题性质</th>
                <th>课题来源</th>
                <th>是否新题</th>
                <th>是否结合实际</th>
                <th>教研室审批</th>
                <th>专业</th>
                <th>备注</th>
                <th>学生学号</th>
                <th>学生姓名</th>
                <th>学生班级</th>
                <th>联系方式</th>
                <th>操作</th>
                </thead>
                <tbody>
                <tr v-for="(item, index) in store" v-bind:class="{ success: editing[index] }">
                    <td >{{index+1}}</td>
                    <td class="revisable"> <textarea class="form-control" type="text" v-model="item.title" disabled="disabled"></textarea></td>
                    <td class="revisable"> <input class="form-control" type="text" v-model="item.nature" disabled="disabled"> </td>
                    <td class="revisable"> <input class="form-control" type="text" v-model="item.source" disabled="disabled">  </td>
                    <td class="revisable">
                        <select class="form-control" name="isNew" id="isnew" v-model="store[index].isnew" disabled="disabled">
                            <option value="true">是</option>
                            <option value="false">否</option>
                        </select>
                    </td>
                    <td class="revisable">
                        <select class="form-control" name="isprac" id="isprac" v-model="store[index].isprac" disabled="disabled">
                            <option value="true">是</option>
                            <option value="false">否</option>
                        </select>
                    </td>
                    <td >{{item.status}}</td>
                    <td>
                        <select class="form-control" name="proname" id="proname" v-model="store[index].proid" disabled="disabled">
                            <?php if(is_array($profess) || $profess instanceof \think\Collection || $profess instanceof \think\Paginator): $i = 0; $__LIST__ = $profess;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $pro['id']; ?>"><?php echo $pro['proname']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td >{{item.note}}</td>
                    <td >{{item.stuidcard}}</td>
                    <td >{{item.stuname}}</td>
                    <td >{{item.stuclass}}</td>
                    <td >{{item.stuphone}}</td>
                    <td >
                        <button  v-show="editing[index]" class="btn btn-success" v-on:click="sure(index)">确定</button>
                        <button  v-show="editing[index]" class="btn btn-warning" v-on:click="cancle(index)">取消</button>
                        <button  v-if="item.status!='已通过'"  v-show="!editing[index]" class="btn btn-primary" v-on:click="edit(index)">编辑</button>
                        <button  v-show="!editing[index]" class="btn btn-danger" v-on:click="del(index)">删除</button>
                    </td>
                </tr>

                <tr id="addItem" v-if="adding">
                    <td>{{this.store.length+1}}</td>
                    <td class="revisable"> <textarea  class="form-control" type="text" v-model="newItem.title" ></textarea></td>
                    <td class="revisable"> <input class="form-control" type="text" v-model="newItem.nature" > </td>
                    <td class="revisable"> <input class="form-control" type="text" v-model="newItem.source" >  </td>
                    <td >
                        <select class="form-control" name="isNew" id="add_isnew" v-model="newItem.isnew">
                            <option value="true">是</option>
                            <option value="false">否</option>
                        </select>
                    </td>
                    <td >
                        <select class="form-control" name="isprac" id="add_isprac" v-model="newItem.isprac">
                            <option value="true">是</option>
                            <option value="false">否</option>
                        </select>
                    </td>
                    <td> </td>
                    <td>
                        <select class="form-control" name="proname" id="add_proname" v-model="newItem.proid" >
                            <?php if(is_array($profess) || $profess instanceof \think\Collection || $profess instanceof \think\Paginator): $i = 0; $__LIST__ = $profess;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $pro['id']; ?>"><?php echo $pro['proname']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td>
                        <button  class="btn btn-success" v-on:click="add_sure">确定</button>
                        <button  class="btn btn-warning" v-on:click="add_cancle">取消</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button class="btn " v-on:click="add()"> 添加 </button>

        <div id="apply_save_student" class="apply_save">
            <h4>教师选择学生截止时间：<span>2019.1.10</span></h4>
            <!--<button  class="btn btn-primary btn-lg" >保存选题学生</button>-->
        </div>
    </div>
    <p >
    <ul>
        规则：
        <li>1. 超期没有申请题目则当年不再安排毕设;</li>
        <li>2. 学生名单显示：若有一志愿学生，则不显示第二志愿学生清单；以此类推，充分保证学生的选题志愿；</li>
        <li>3. 如果毕设题目没有学生选择，则在 未选毕设题目 学生清单中选择，教师仍然可以选择学生；</li>
        <li>4. 如果教师没有选择学生则自动调剂；</li>
    </ul>
    </p>
    <hr>
    <div id="apply_stu">
        <div id="apply_remind2" >
            <span>2019</span>
            <span> 届 学生毕设过程管理</span>
        </div>

        <div id="apply_graph2">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <th>序号</th>
                <th>题目</th>
                <th>学生学号</th>
                <th>学生姓名</th>
                <th>学生班级</th>
                <th>开题时间</th>
                <th>中期检查时间</th>
                <th>答辩时间</th>
                <th>答辩地点</th>
                <th>答辩成绩</th>
                <th>操作</th>
                </thead>
                <tbody>
                <tr v-for="(item, index) in store">
                    <td >{{item.id}}</td>
                    <td>{{item.title}}</td>
                    <td>{{item.stuidcard}}</td>
                    <td>{{item.stuname}}</td>
                    <td>{{item.stuclass}}</td>
                    <td>{{item.starttimer}}</td>
                    <td>{{item.middletimer}}</td>
                    <td>{{item.replytimer}}</td>
                    <td>{{item.replyplace}}</td>
                    <td><input class="form-control" type="text" v-model="item.replyscore" disabled="disabled"></td>
                    <td class="revisable" >
                        <button v-show="editing[index]" class="btn btn-success" v-on:click="sure(index)">确定</button>
                        <button v-if="!(item.replyscore!='0')" v-show="!editing[index]" class="btn btn-primary stu_edit"  v-on:click="edit(index)">编辑</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <!--<button id="apply_save_data" class="btn btn-primary btn-lg" >保存数据</button>-->

            <!-- end #apply_stu -->
        </div>
    </div>
</div>
<!-- end #apply -->



<div id="manage">
    <div id="apply_remind3" >
        <span>2019</span>
        <span> 届 教师管理学生</span>
    </div>

    <div id="manage_graph">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <th>序号</th>
            <th>题目</th>
            <th>是否提交</th>
            <th>学生姓名</th>
            <th>学生学号</th>
            <th>学生姓名</th>
            <th>学生班级</th>
            <th>学生电话</th>
            <th>操作</th>
            </thead>
            <tbody>
            <tr v-for="(item,index) in store" >
                <td>{{item.id}}</td>
                <td>{{item.title}}</td>
                <td>{{c_isSbumit(index)}}</td>
                <td>{{item.stuname}}</td>
                <td>{{item.stuidcard}}</td>
                <td>{{item.stuname}}</td>
                <td>{{item.stuclass}}</td>
                <td>{{item.stuphone}}</td>
                <td class="revisable" >
                    <button  class="btn btn-success" v-on:click="allow(index)">允许</button>
                    <button  class="btn btn-warning " v-on:click="reject(index)">拒绝</button>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>




<script src="http://127.0.0.1/gmis/public/home/js/base.js"></script>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/tapply/tapply.js"></script>
</body>
</html>