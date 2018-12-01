<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"C:\wamp64\www\gmis\public/../application/index\view\sselect\index.html";i:1543629581;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生毕设选题系统</title>
    <link rel="stylesheet" href="http://127.0.0.1/gmis/public/home/css/sselect.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="apply" v-cloak>
        <h4 id="apply_remind" >
            <span>2019</span>
            <span>届 毕设题目查询</span>
            <select name="profess" id="profess"  class="form-control">
                <?php if(is_array($profess) || $profess instanceof \think\Collection || $profess instanceof \think\Paginator): $i = 0; $__LIST__ = $profess;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $pro['id']; ?>"><?php echo $pro['proname']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
            <input class="form-control" type="text"   v-model="searchContent" name="tile_key" id="tile_key" placeholder="关键字">
            <button class="btn">查询</button>
        </h4>
        <div id="apply_graph" >
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <th>选择</th>
                    <th>序号</th>
                    <th>题目</th>
                    <th>课题性质</th>
                    <th>课题来源</th>
                    <th>是否新题</th>
                    <th>是否结合实际</th>
                    <th>教研室审批意见</th>
                    <th>已选人数（上限10）</th>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in filterData">
                        <td><input type="checkbox" v-model="store[index].pick" v-on:click="change(index)"></td>
                        <td>{{index+1}}</td>
                        <td>{{item.title}}</td>
                        <td>{{item.nature}}</td>
                        <td>{{item.source}}</td>
                        <td>{{item.isNew | shift}}</td>
                        <td>{{item.isPrac | shift}}</td>
                        <td>{{item.status}}</td>
                        <td>{{item.total}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        
        <div id="apply_stu" v-cloak>
            <div id="apply_remind2" >
                <h4> 已选题目查询</h4>
                <span> 每个学生最多选3个毕设题目，请在序号中使用1、2、3填写毕设题目顺序，如果教师没有选择该生则自动调剂。</span>
            </div>
            <div id="apply_graph2">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <th>序号调整</th>
                        <th>题目</th>
                        <th>课题性质</th>
                        <th>课题来源</th>
                        <th>是否新题</th>
                        <th>是否结合实际</th>
                        <th>教研室审批意见</th>
                        <th>指导教师</th>
                        <th>指导教师联系电话</th>
                        <th>该题选择人数</th>
                    </thead>
                    <tbody v-if="picked!=[]">
                        <tr v-if="picked!=[]" v-for="(item, index) in picked" >
                            <td>
                                <a href="#" v-on:click="upon(index)">
                                    <span class="glyphicon glyphicon-arrow-up"></span>
                                </a>
                                <a href="#" v-on:click="down(index)">
                                    <span class="glyphicon glyphicon-arrow-down"></span>
                                </a>
                            </td>
                            <td>{{item.title}}</td>
                            <td>{{item.nature}}</td>
                            <td>{{item.source}}</td>
                            <td>{{item.isnew | shift}}</td>
                            <td>{{item.isprac | shift}}</td>
                            <td>{{item.a7}}</td>
                            <td>{{item.a8}}</td>
                            <td>{{item.a9}}</td>
                            <td>{{item.a11}}</td>
                        </tr>    
                    </tbody>
                </table>

            <button id="apply_save_data" class="btn btn-primary btn-lg" v-on:click="submit()" >提交数据</button>
        <!-- end #apply_stu -->
            </div>

            <div id="apply_remind3" >
                <h4>已提交数据</h4>
            </div>
            <div id="apply_graph3">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                    <th>题目</th>
                    <th>课题性质</th>
                    <th>课题来源</th>
                    <th>是否新题</th>
                    <th>是否结合实际</th>
                    <th>是否通过审核</th>
                    <th>教研室审批意见</th>
                    <th>指导教师</th>
                    <th>指导教师联系电话</th>
                    <th>该题选择人数</th>
                    </thead>
                    <tbody>
                    <?php if(is_array($submit) || $submit instanceof \think\Collection || $submit instanceof \think\Paginator): $i = 0; $__LIST__ = $submit;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sd): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $sd['title']; ?></td>
                        <td><?php echo $sd['nature']; ?></td>
                        <td><?php echo $sd['source']; ?></td>
                        <td><?php echo $sd['isnew']; ?></td>
                        <td><?php echo $sd['isprac']; ?></td>
                        <td><?php echo $sd['isallow']; ?></td>
                        <td><?php echo $sd['status']; ?></td>
                        <td><?php echo $sd['teaname']; ?></td>
                        <td><?php echo $sd['teaphone']; ?></td>
                        <td><?php echo $sd['total']; ?></td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="apply_remind4" >
                <h4>已通过申请</h4>
            </div>
            <div id="apply_graph4">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                    <th>题目</th>
                    <th>学生学号</th>
                    <th>学生姓名</th>
                    <th>学生班级</th>
                    <th>开题时间</th>
                    <th>中期检查时间</th>
                    <th>答辩时间</th>
                    <th>答辩地点</th>
                    <th>教师姓名</th>
                    <th>答辩成绩</th>
                    </thead>
                    <tbody>
                    <?php if(is_array($allow) || $allow instanceof \think\Collection || $allow instanceof \think\Paginator): $i = 0; $__LIST__ = $allow;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$al): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $al['title']; ?></td>
                        <td><?php echo $al['stuidcard']; ?></td>
                        <td><?php echo $al['stuname']; ?></td>
                        <td><?php echo $al['stuclass']; ?></td>
                        <td><?php echo $al['starttimer']; ?></td>
                        <td><?php echo $al['middletimer']; ?></td>
                        <td><?php echo $al['replytimer']; ?></td>
                        <td><?php echo $al['replyplace']; ?></td>
                        <td><?php echo $al['teaname']; ?></td>
                        <td><?php echo $al['replyscore']; ?></td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- end #apply -->
    <script src="http://127.0.0.1/gmis/public/home/js/base.js"></script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
    <script src="http://127.0.0.1/gmis/public/home/js/sselect/sselect.js"></script>
</body>
</html>