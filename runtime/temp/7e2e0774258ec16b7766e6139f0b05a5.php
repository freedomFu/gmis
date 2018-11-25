<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"C:\wamp64\www\gmis\public/../application/index\view\sselect\index.html";i:1543089811;}*/ ?>
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
 
    <div id="apply">

        <h4 id="apply_remind" >
            <span>2019</span>
            <span>届 毕设题目查询</span>
            <select name="profess" id="profess"  class="form-control">
                <option value="1">专业1</option>
                <option value="2">专业2</option>
                <option value="3">专业3</option>
                <option value="4">专业4</option>
                <option value="5">专业5</option>
                <option value="6">专业6</option>
                <option value="7">专业7</option>
                <option value="8">专业8</option>
                <option value="9">专业9</option>
                <option value="10">专业10</option>
            </select>
            <input class="form-control" type="text" name="tile_key" id="tile_key" placeholder="关键字">
            <button class="btn">查询</button>
        </h4>
        <div id="apply_graph">
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
                    <tr v-for="(book, index) in store">
                        <td><input type="checkbox" v-model="store[index].pick" v-on:click="change(index)"></td>
                        <td>{{index+1}}</td>
                        <td>{{book.title}}</td>               
                        <td>{{book.nature}}</td>                        
                        <td>{{book.source}}</td>
                        <td></td> 
                        <td></td>                 
                        <td>{{book.a7}}</td>
                        <td>{{book.a8}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

      

        <hr>
        
        <div id="apply_stu">
            <div id="apply_remind2" >
                <h4> 已选题目查询</h4>
                <span> 每个学生最多选3个毕设题目，请在序号中使用1、2、3填写毕设题目顺序，如果教师没有选择该生则自动调剂。</span>

            </div>

            <div id="apply_graph2">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                        <th>序号调整</th>
                        <th>题目</th>s
                        <th>课题性质</th>
                        <th>课题来源</th>
                        <th>是否新题</th>
                        <th>是否结合实际</th>
                        <th>教研室审批意见</th>
                        <th>指导教师</th>
                        <th>指导教师联系电话</th>
                        <th>该题选择人数</th>
                    </thead>
                    <tbody v-if="picked.length>1">
                        <tr v-for="(book, index) in picked" v-if="index!=0">
                            <td>
                                <a href="#" v-on:click="upon(index)">
                                    <span class="glyphicon glyphicon-arrow-up"></span>
                                </a>
                                <a href="#" v-on:click="down(index)">
                                    <span class="glyphicon glyphicon-arrow-down"></span>
                                </a>
                            
                            
                            </td>
                            <td>{{book.title}}</td>               
                            <td>{{book.nature}}</td>                        
                            <td>{{book.source}}</td>
                            <td>{{book.isNew}}</td>                  
                            <td>{{book.isAllow}}</td>
                            <td>{{book.a7}}</td>
                            <td>{{book.a8}}</td>
                            <td>{{book.a9}}</td>                  
                            <td>{{book.a11}}</td>
                        </tr>    
                    </tbody>
                </table>

            <button id="apply_save_data" class="btn btn-primary btn-lg" >保存数据</button>
        <!-- end #apply_stu -->
    </div>
        </div>
    </div>
    <!-- end #apply -->
    <script src="data.js"></script>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
    <script src="http://127.0.0.1/gmis/public/home/js/sselect/sselect.js"></script>
</body>
</html>