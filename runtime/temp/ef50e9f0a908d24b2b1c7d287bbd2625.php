<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"C:\wamp64\www\gmis\public/../application/index\view\tapply\index.html";i:1542958093;}*/ ?>
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
<div id="map">
    <h3 class="title">毕设流程图</h3>
    <div id="map_box">
        <?php if(is_array($prochart) || $prochart instanceof \think\Collection || $prochart instanceof \think\Paginator): $i = 0; $__LIST__ = $prochart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
            <div>
                <span><?php echo $pro['proname']; ?></span><br>
                <span>(<?php echo $pro['protimer']; ?>)</span>
            </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!-- end #map -->

<div id="apply">

    <h4 id="apply_remind" >
        <span>2019</span>
        <span>届 毕设题目申请（您可申请题目为<span>{{max}}</span>个，请填写备注之前信息）</span>
    </h4>
    <button class="btn btn-primary" v-on:click="add">添加一行</button>
    <span class="tips">Tips:点击修改</span>
    <div id="apply_graph">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
            <th>序号</th>
            <th>题目</th>
            <th>课题性质</th>
            <th>课题来源</th>
            <th>是否新题</th>
            <th>是否结合实际</th>
            <th>教研室审批</th>
            <th>备注</th>
            <th>学生学号</th>
            <th>学生姓名</th>
            <th>学生班级</th>
            <th>联系方式</th>
            <th>删除</th>
            </thead>
            <tbody>
            <tr v-for="(book, index) in store">
                <td >{{index+1}}</td>
                <td class="revisable">{{book.title}}</td>
                <td class="revisable">{{book.nature}}</td>
                <td class="revisable">{{book.source}}</td>
                <td >
                    <select class="form-control" name="isNew" id="isNew" v-model="store[index].isNew">
                        <option value="true">是</option>
                        <option value="false">否</option>
                    </select>
                </td>
                <td >
                    <select class="form-control" name="isAllow" id="isAllow" v-model="store[index].isAllow">
                        <option value="true">是</option>
                        <option value="false">否</option>
                    </select>
                </td>
                <td >{{book.a7}}</td>
                <td >{{book.a8}}</td>
                <td >{{book.a9}}</td>
                <td >{{book.a10}}</td>
                <td >{{book.a11}}</td>
                <td >{{book.a12}}</td>
                <td  ><button class="btn" v-on:click="del(index)">删除</button></td>
            </tr>

            </tbody>
        </table>
    </div>

    <div id="apply_save_issue" class="apply_save">
        <h4>毕设题目申请截止时间：<span>2019.1.1</span></h4>
        <button class="btn btn-primary btn-lg">毕设题目申请/修改</button>
    </div>
    <div id="apply_save_student" class="apply_save">
        <h4>教师选择学生截止时间：<span>2019.1.10</span></h4>
        <button  class="btn btn-primary btn-lg" >保存选题学生</button>
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
                <th>123</th>
                <th>123</th>
                <th>12d</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>

                </thead>
                <tbody>
                <tr v-for="(book, index) in store">
                    <td class="NO">{{index+1}}</td>
                    <td>{{book.a2}}</td>
                    <td>{{book.a3}}</td>
                    <td>{{book.a4}}</td>
                    <td>{{book.a5}}</td>
                    <td>{{book.a6}}</td>
                    <td>{{book.a7}}</td>
                    <td>{{book.a8}}</td>
                    <td>{{book.a9}}</td>
                    <td>{{book.a10}}</td>
                    <td>{{book.a11}}</td>
                    <td>{{book.a12}}</td>
                </tr>
                </tbody>
            </table>

            <button id="apply_save_data" class="btn btn-primary btn-lg" >保存数据</button>


            <!-- end #apply_stu -->
        </div>
    </div>

</div>
<!-- end #apply -->



<div id="pre">
    <h3>往届题目查询</h3>
    <div id="pre_bar">
        <p>毕设年度
            <select name="" id="">
                <option value="">2018</option>
                <option value="">2017</option>
                <option value="">2016</option>
                <option value="">2015</option>
                <option value="">2014</option>
            </select>
            <button class="btn btn-primary btn-lg">查询</button>
        </p>

        <div id="pre_graph">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <th>123</th>
                <th>123</th>
                <th>12d</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>
                <th>123</th>

                </thead>
                <tbody v-for="(data1d, index1d) in data2d" v-show="page[index1d]">
                <tr v-for="(data, index) in data1d" >
                    <td >{{index1d*10+index+1}}</td>
                    <td>{{data.a2}}</td>
                    <td>{{data.a3}}</td>
                    <td>{{data.a4}}</td>
                    <td>{{data.a5}}</td>
                    <td>{{data.a6}}</td>
                    <td>{{data.a7}}</td>
                    <td>{{data.a8}}</td>
                    <td>{{data.a9}}</td>
                    <td>{{data.a10}}</td>
                    <td>{{data.a11}}</td>
                    <td>{{data.a12}}</td>
                </tr>
                </tbody>
            </table>


            <div id="operation">

                <ul class="pagination">
                    <li ><a v-on:click="pre">&laquo;</a></li>
                    <li v-for="(aa,index) in data2d" v-on:click="turnTo(index+1)" v-show="isNear(index)"><a>{{index+1}} </a></li>
                    <li><a  v-on:click="next">&raquo;</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


<script src="http://127.0.0.1/gmis/public/home/js/data.js"></script>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
<script src="http://127.0.0.1/gmis/public/home/js/tapply/tapply.js"></script>
</body>
</html>