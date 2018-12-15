<?php
namespace app\home\model;
use app\home\model\Process;
use app\home\model\Comclass;
use think\Model;
use think\Db;

class Tapply extends Model{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * 教师申请题目模型
     * @author fyd
     */

    //获取器修改时间格式
    public function getcreatetimeAttr($value,$data){
        $value = $value ? $value: (isset($data['refreshtime']) ? $data['createtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s",$value) : $value;
    }
    public function getRefreshtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['refreshtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    /**
     * @Description: 显示专业
     * @DateTime:    2018/11/27 10:52
     * @Author:      fyd
     */
    public function showProfess(){
        $table = "profess";
        $field = "id,proname";
        $where['status'] = "正常";
        $list = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        return $list;
    }

    /**
     * @Description: 展示当前教师的申请内容
     * @DateTime:    2018/11/27 10:52
     * @Author:      fyd
     */
    public function show($teaid,$xq,$page,$limit){
        $where['teaid'] = $teaid;
        $where['belongsenior'] = $xq;
        $maintable = 'tapply';
        $field = 'ta.id,title,nature,source,isnew,isprac,ta.proid,proname,note,ta.status,stuidcard,stuname,stuclass,stuphone';
        $mt = 'ta';
        $join = [
            ['gmis_student gs','gs.id=ta.stuid','LEFT'],
            ['gmis_profess gp','gp.id=ta.proid','LEFT'],
        ];
        $list = Db::name($maintable)
            ->alias($mt)
            ->join($join)
            ->field($field)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        $com = new Comclass();
        for($i=0;$i<count($list);$i++){
            $nature = $list[$i]["nature"];
            $source = $list[$i]["source"];
            $list[$i]["naturename"] = $com->getTeaName("nature",$nature);
            $list[$i]["sourcename"] = $com->getTeaName("source",$source);
        }
        return $list;
    }

    public function getOldNum($teaid,$year){
        $where['teaid'] = $teaid;
        $where['belongsenior'] = $year;
        $where['status'] = "已通过";
        $maintable = 'tapply';
        $count = Db::name($maintable)
            ->where($where)
            ->count();
        return $count;
    }

    public function showOld($teaid,$page,$limit,$year){
        $where['teaid'] = $teaid;
        $where['belongsenior'] = $year;
        $where['ta.status'] = "已通过";
        $maintable = 'tapply';
        $field = 'ta.id,title,nature,source,isnew,isprac,ta.proid,proname,note,ta.status,stuidcard,stuname,stuclass,stuphone';
        $mt = 'ta';
        $join = [
            ['gmis_student gs','gs.id=ta.stuid','LEFT'],
            ['gmis_profess gp','gp.id=ta.proid','LEFT'],
        ];
        $list = Db::name($maintable)
            ->alias($mt)
            ->join($join)
            ->field($field)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        $com = new Comclass();
        for($i=0;$i<count($list);$i++){
            $nature = $list[$i]["nature"];
            $source = $list[$i]["source"];
            $list[$i]["naturename"] = $com->getTeaName("nature",$nature);
            $list[$i]["sourcename"] = $com->getTeaName("source",$source);
        }
        return $list;
    }

    /**
     * @Description: 新增数据
     * @DateTime:    2018/11/27 10:53
     * @Author:      fyd
     */
    public function add($data){
        if(empty($data['title']) || empty($data['nature']) || empty($data['source']) || ($data['proid']==0)){
            return 3;
        }

        $tapply = new Tapply($data);
        $title = $data['title'];
        $uniCheck = Tapply::checkTitle($title);
        if($uniCheck){
            return 2; //已经有存在的标题
        }

        $res = $tapply->save();
        if($res){
            return 1; //代表添加成功
        }else{
            return 0; //代表系统原因添加失败
        }
    }

    /**
     * @Description: 审核标题
     * @DateTime:    2018/11/27 10:53
     * @Author:      fyd
     */
    protected static function checkTitle($title){
        $where['title'] = $title;
        $uniCheck = Tapply::where($where)
            ->find();
        if($uniCheck){
            return true; //已经有存在的标题
        }else{
            return false;
        }
    }

    /**
     * @Description: $data是指新提交的数据   编辑
     * @DateTime:    2018/11/27 10:53
     * @Author:      fyd
     */
    public function edit($id, $data,$xq){
        $tapply = new Tapply();
        $where['id'] = $id;
        $where['belongsenior'] = $xq;
        $isAllow = $this->checkIsAllow($id);
        if($isAllow){
            return 3; // 已经通过申请，不能再添加了
        }

        $oldData = $tapply
            ->where($where)
            ->find();
        $oldTitle = $oldData['title']; //原来数据库中的标题
        $newTitle = $data['title']; //新输入的标题

        if($oldTitle!=$newTitle){ //标题发生变化
            $checkNewTitle = Tapply::checkTitle($newTitle);
            if($checkNewTitle){
                return 2; //新标题与数据库中数据重复
            }
        }
        $ta = Tapply::get($id);
        $res = $ta->save($data);
        if($res){
            return 1; //修改成功
        }else{
            return 0; //修改失败
        }
    }

    /**
     * @Description: 判断这个id对应的数据是不是已经通过，如果已经通过了，就不可以再编辑了
     * @DateTime:    2018/11/27 10:53
     * @Author:      fyd
     */
    public function checkIsAllow($titleid){
        $where['id'] = $titleid;
        $isAllow = Tapply::where($where)
            ->value('status');
        if($isAllow == "已通过"){
            return 1;
        }elseif($isAllow == "未通过"){
            return 0;
        }
    }

    /**
     * @Description: 删除数据
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    public function del($id){
        $isAllow = $this->checkIsAllow($id);
        if($isAllow){
            return 2; // 已经通过申请，不能再删除了
        }

        $ta = Tapply::get($id);
        if($ta){
            $res = $ta->delete();
            if($res){
                return 1; //删除成功
            }else{
                return 0; //删除失败
            }
        }else{
            return 3;
        }
    }

    /**
     * @Description: 获取题目数量
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    public function getTitleNum($teaid){
        $where['id'] = $teaid;
        $tableName = 'teacher';
        $titleNum = Db::name($tableName)
            ->where($where)
            ->value('teatitlenum');
        return $titleNum;
    }

    /**
     * @Description: 获取已经申请的
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    public function getAppliedNum($teaid,$xq){
        $where['teaid'] = $teaid;
        $where['belongsenior'] = $xq;
        $total = Tapply::where($where)
            ->count();
        return $total;
    }

    /**
     * @Description: 教师生成选择表单
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    public function showSelectStu($teaid,$xq,$page,$limit){
        /**
         * 对于sselect表中的数据进行处理
         * 选择当前教师对应的题目以及学生并显示出来
         *
         * 对于选择上的学生，学生申请的其他数据作废
         * 并且学生不能再申请题目  逻辑中只要存在提交过的就不可以再申请了
         *
         * 然后最后一项，需要把教师选择的题目存入到prochart表，并且把tapply中的数据更新
         */
        $table = 'sselect';
        $mt = 'ss';
        $where['ss.teaid'] = $teaid;
        $where['ss.belongSenior'] = $xq;
        $where['ss.issubmit'] = 1;
        $where['ss.isallow'] = 0;
        $where['ss.status'] = '正常';

        $field = 'ss.id,gt.title,ss.issubmit,gs.stuidcard,stuname,stuclass,gs.stuphone';
        $join = [
            ['gmis_tapply gt','gt.id=ss.titleid','LEFT'],
            ['gmis_student gs','gs.id=ss.stuid','LEFT'],
        ];
        $list = Db::name($table)
            ->alias($mt)
            ->field($field)
            ->join($join)
            ->where($where)
            ->order('ss.id desc ss.weigh asc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $list;
    }

    /**
     * @Description: 获取总数
     * @DateTime:    2018/11/29 22:17
     * @Author:      fyd
     */
    public function selectStuCount($teaid, $xq){
        $table = 'sselect';
        $mt = 'ss';
        $where['ss.teaid'] = $teaid;
        $where['ss.belongSenior'] = $xq;
        $where['ss.issubmit'] = 1;
        $where['ss.isallow'] = 0;
        $where['ss.status'] = '正常';

        $count = Db::name($table)
            ->alias($mt)
            ->where($where)
            ->count();
        return $count;
    }

    /**
     * @Description: 根据id获取学生id
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    private function ccselect($id,$value){
        $table = 'sselect';
        $where['id'] = $id;
        $where['status'] = '正常';
        $stuid = Db::name($table)
            ->where($where)
            ->value($value);
        return $stuid;
    }

    /**
     * @Description: 把对应学生的其他选择隐藏
     * @DateTime:    2018/11/27 10:54
     * @Author:      fyd
     */
    private function cutdownStu($stuid, $id){
        $table = 'sselect';
        $field = 'id';
        $where['status'] = '正常';
        $where['stuid'] = $stuid;
        $stuidArr = Db::name($table)
            ->field($field)
            ->where($where)
            ->select();
        $count = count($stuidArr);
        for ($i=0;$i<$count;$i++){
            $checkid = $stuidArr[$i]['id'];
            if($checkid==$id){
                continue;
            }
            $update = ['status'=>'隐藏'];
            $wherecheck['id'] = $checkid;
            Db::name($table)
                ->where($wherecheck)
                ->update($update);
        }
    }

    /**
     * @Description: 修改tapply表中的数据
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    private function dbTaUpdate($id){
        $stuid = $this->ccselect($id,'stuid');
        $title = $this->ccselect($id,'titleid');
        $table = 'tapply';
        $where['id'] = $title;
        $where['status'] = '已通过';
        $where['stuid'] = null;
        $update = ['stuid'=>$stuid];
        $res = Db::name($table)
            ->where($where)
            ->update($update);
        return $res;
    }

    /**
     * @Description: 添加到process表中
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    private function dbProUpdate($id){
        $titleid = $this->ccselect($id,'titleid');
        $stuid = $this->ccselect($id,'stuid');
        $teaid = $this->ccselect($id,'teaid');

        $data = [
            'titleid'       =>  $titleid,
            'stuid'         =>  $stuid,
            'teaid'         =>  $teaid,
            'belongsenior'  =>  getSenior()
        ];
        $pro = new Process();
        $pro -> save($data);
    }

    /**
     * @Description: 确认选择这个学生
     * @DateTime:    2018/11/27 10:55
     * @Author:      fyd
     */
    public function chooseTitle($id){
        $table = 'sselect';
        $stuid = $this->ccselect($id,'stuid');
        $isallow = $this->ccselect($id,'isallow');

        if($isallow==1){
            return 2; //这一项已经通过了申请，不能再更新
        }
        $where['id'] = $id;
        $where['issubmit'] = 1;
        $updatedata = ['isallow'=>1];
        Db::startTrans();
        try{
            $res = Db::name($table)
                ->where($where)
                ->update($updatedata);
            $this->cutdownStu($stuid,$id);
            $this->dbTaUpdate($id);
            $this->dbProUpdate($id);
            // 提交事务
            Db::commit();
        }catch(\think\Exception\DbException $e){
            Db::rollback();
            return 3;
        }

        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @Description: 获取课题性质
     * @DateTime:    2018/12/15 16:37
     * @Author:      fyd
     */
    public function getNature(){
        $res = Db::name("nature")
            ->select();
        return $res;
    }

    /**
     * @Description: 获取课题来源
     * @DateTime:    2018/12/15 16:38
     * @Author:      fyd
     */
    public function getSource(){
        $res = Db::name("source")
            ->select();
        return $res;
    }
}