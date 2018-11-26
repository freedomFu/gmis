<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/13 22:01
 * @Description: 描述信息
 */
namespace app\index\model;

use app\index\model\Process;
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

    private function isTrue($val){
        if($val==1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/26 7:42
     * @Description: 显示专业
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
     * @Author:      fyd
     * @DateTime:    2018/11/20 11:10
     * @Description: 展示当前教师的申请内容
     */
    public function show($teaid,$xq){
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
            ->select();

        $count = count($list);
        for($i=0;$i<$count;$i++){
            $isnew = $list[$i]['isnew'];
            $isprac = $list[$i]['isprac'];
            $list[$i]['isnew'] = $this->isTrue($isnew);
            $list[$i]['isprac'] = $this->isTrue($isprac);
        }
        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:53
     * @Description: 新增数据
     */
    public function add($data){
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
     * @Author:      fyd
     * @DateTime:    2018/11/14 11:01
     * @Description: 审核标题
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
     * @Author:      fyd
     * @DateTime:    2018/11/14 10:53
     * @Description: $data是指新提交的数据
     */
    public function edit($id, $data){
        $tapply = new Tapply();
        $where['id'] = $id;

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
     * @Author:      fyd
     * @DateTime:    2018/11/18 20:26
     * @Description: 判断这个id对应的数据是不是已经通过，如果已经通过了，就不可以再编辑了
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
     * @Author:      fyd
     * @DateTime:    2018/11/15 10:18
     * @Description: 删除数据
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
     * @Author:      fyd
     * @DateTime:    2018/11/18 15:33
     * @Description: 获取题目数量
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
     * @Author:      fyd
     * @DateTime:    2018/11/18 15:42
     * @Description: 获取已经申请的
     */
    public function getAppliedNum($teaid){
        $where['teaid'] = $teaid;
        $total = Tapply::where($where)
            ->count();
        return $total;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/24 7:42
     * @Description: 教师生成选择表单
     */
    public function showSelectStu($teaid,$xq){
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

        $field = 'ss.id,gt.title,ss.issubmit,gs.stuidcard,gs.stupwd,stuname,stuclass';
        $join = [
            ['gmis_tapply gt','gt.id=ss.titleid','LEFT'],
            ['gmis_student gs','gs.id=ss.stuid','LEFT'],
        ];
        $list = Db::name($table)
            ->alias($mt)
            ->field($field)
            ->join($join)
            ->where($where)
            ->select();
        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/24 14:17
     * @Description: 根据id获取学生id
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
     * @Author:      fyd
     * @DateTime:    2018/11/24 15:13
     * @Description: 把对应学生的其他选择隐藏
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
     * @Author:      fyd
     * @DateTime:    2018/11/24 13:50
     * @Description: 修改tapply表中的数据
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
     * @Author:      fyd
     * @DateTime:    2018/11/24 13:49
     * @Description: 添加到process表中
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
     * @Author:      fyd
     * @DateTime:    2018/11/24 13:48
     * @Description: 确认选择这个学生
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
        }catch(\Exception $e){
            Db::rollback();
        }

        if($res){
            return 1;
        }else{
            return 0;
        }

    }
}