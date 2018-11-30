<?php
namespace app\home\model;
use app\home\model\Tapply;
use think\Model;
use think\Db;

class Sselect extends Model
{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    /**
     * 学生选择论文题目
     * @author fyd
     */
    //获取器修改时间格式
    public function getcreatetimeAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['createtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }
    public function getRefreshtimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['refreshtime']) ? $data['refreshtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    /**
     * @Description: 显示专业
     * @DateTime:    2018/11/27 10:46
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
     * @Description: 显示选择列表
     * @DateTime:    2018/11/26 11:38
     * @Author:      fyd
     */
    public function sselect($stuid){
        $where['status'] = '正常';
        $where['stuid'] = $stuid;
        $list = Sselect::order('id desc')
            ->where($where)
            ->select();
        return $list;
    }

    /**
     * @Description: 获取筛选信息
     * @DateTime:    2018/11/27 10:46
     * @Author:      fyd
     */
    public function showApplyTitle($professid, $titlekey,$senior,$page,$limit){
        $where['belongsenior']=$senior;
        $where['status'] = "已通过";
        $where['stuid'] = null;
        $field = "id,title,nature,source,isnew,isprac,proid,status";
        //都没有传入
        if(!($professid==0)){
            $where['proid'] = $professid;
        }
        if(!empty($titlekey)){
            $where['title'] = ['like','%'.$titlekey.'%'];
        }
        $list = Tapply::where($where)
            ->field($field)
            ->order('id desc')
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $list;
    }

    public function countApplyNum($professid, $titlekey,$senior){
        $where['belongsenior']=$senior;
        $where['status'] = "已通过";
        $where['stuid'] = null;
        if(!($professid==0)){
            $where['proid'] = $professid;
        }
        if(!empty($titlekey)){
            $where['title'] = ['like','%'.$titlekey.'%'];
        }
        $count = Tapply::where($where)
            ->order('id desc')
            ->count();
        return $count;
    }

    /**
     * @Description: 根据专业id获取专业名称
     * @DateTime:    2018/11/27 10:46
     * @Author:      fyd
     */
    public function getProfessName($professid){
        $where['id'] = $professid;
        $where['status'] = "正常";
        $res = Db::name('profess')
            ->where($where)
            ->find();
        return $res['proname'];
    }

    /**
     * @Description: 获取当前题目总数
     * @DateTime:    2018/11/27 10:47
     * @Author:      fyd
     */
    public function getCount($titleid){
        $where['titleid'] = $titleid;
//        $where['issubmit'] = 1; //已经提交
        $where['status'] = "正常";
        $total = Db::name('sselect')
            ->where($where)
            ->count();
        return $total;
    }

    /**
     * @Description: 获取pick值
     * @DateTime:    2018/11/27 10:47
     * @Author:      fyd
     */
    public function getPick($titleid, $stuid){
        $where['titleid'] = $titleid;
        $where['stuid'] = $stuid;
        $where['status'] = "正常";
        $where['isallow'] = 0;
        $res = Sselect::where($where)
            ->value('pick');
        return $res;
    }

    /**
     * @Description: 根据titleid获取teaid
     * @DateTime:    2018/11/27 10:47
     * @Author:      fyd
     */
    private function getTeaid($titleid){
        $where['status'] = "已通过";
        $where['id'] = $titleid;
        $teaid = Db::name('tapply')
            ->where($where)
            ->value('teaid');
        return $teaid;
    }

    /**
     * @Description: 检验这个数据能否保存
     * @DateTime:    2018/11/27 10:48
     * @Author:      fyd
     */
    private function checkSave($stuid){

        $where['stuid'] = $stuid;
        $where['status'] = '正常';
        $total = Sselect::where($where)
            ->count();
        if($total>=3){
            return 1;
        }
        $where2['stuid']=$stuid;
        $where2['isallow']=1;
        $where2['status']='正常';
        $isallow = Sselect::where($where2)
            ->find();
        if($isallow){
            return 2;
        }

        return 3;
    }

    /**
     * @Description: 保存数据
     * @DateTime:    2018/11/26 11:45
     * @Author:      fyd
     */
    public function saveOne($stuid, $dataid,$xq){
        $titleid = $dataid; //题目id
        $teaid = $this->getTeaid($titleid);
        $check = $this->checkSave($stuid);
        if($check==1){
            return 2;
        }elseif($check==2){
            return 3;
        }

        $whereAll['titleid']=$titleid;
        $whereAll['teaid']=$teaid;
        $whereAll['stuid']=$stuid;
        $whereAll['status']="正常";
        $whereAll['belongSenior']=$xq;
        $whereAll['isallow']=0;

        $isAllowed = Sselect::where($whereAll)
            ->find();
        if($isAllowed){
            return 4; //已经提交过了
        }


        $data = [
            'stuid'         =>      $stuid,
            'titleid'       =>      $titleid,
            'teaid'         =>      $teaid,
            'pick'          =>      'true',
            'isallow'       =>      0,
            'issubmit'      =>      0,
            'belongSenior'  =>      $xq
        ];

        $res = Sselect::save($data);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @Description: 取消勾
     * @DateTime:    2018/11/26 16:37
     * @Author:      fyd
     */
    public function delOne($stuid, $dataid, $xq){
        $titleid = $dataid;
        $teaid = $this->getTeaid($titleid);
        $where['stuid']=$stuid;
        $where['titleid']=$titleid;
        $where['teaid']=$teaid;
        $where['belongSenior']=$xq;
        $where['status']="正常";
        $where['isallow']=0;
        $id = Sselect::where($where)
            ->value("id");

        $ss = Sselect::get($id);
        $res = $ss -> delete();
        if($res){
            return 1;
        }else{
            return 0;
        }

    }

    /**
     * @Description: 保存数据，但是没有提交，获取的是titleid，已经通过的
     * @DateTime:    2018/11/27 10:49
     * @Author:      fyd
     */
    public function saveData($stuid,$dataid){
        $count = count($dataid);
        for($j=0;$j<$count;$j++){
            $data[$j]=[];
        }
        for($i=0;$i<$count;$i++){
            $titleid = $dataid[$i];
            $data[$i] = [
                'stuid'     =>  $stuid,
                'titleid'   =>  $titleid,
                'teaid'     =>  $this->getTeaid($titleid),
                'issubmit'  =>  0
            ];
        }
        $res = Sselect::saveall($data);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @Description: 判断是否还可以申请
     * @DateTime:    2018/11/27 10:51
     * @Author:      fyd
     */
    public function checkStuTitleNum($stuid,$dataid){
        //若已经有提交的就不能再添加了
        $wherecheck['stuid'] = $stuid;
        $wherecheck['issubmit']=1;
        $wherecheck['status'] = '正常';
        $checkIsAllow = Sselect::where($wherecheck)
            ->find();
        if($checkIsAllow){
            return 4;
        }

        $count = count($dataid);
        if($count>3){
            return 2;
        }
        $where['stuid'] = $stuid;
        $where['status'] = '正常';
        $num = Sselect::where($where)
            ->count();

        $num+=$count;

        if($num>3){
            return 3;
        }
        return 1;
    }

    /**
     * @Description: 提交数据
     * @DateTime:    2018/11/27 10:51
     * @Author:      fyd
     */
    public function submitData($stuid,$xq){
        $where['status']="正常";
        $where['stuid']=$stuid;
        $where['isallow']=0;
        $where['belongSenior']=$xq;

        $stuselect = Sselect::where($where)
            ->where('issubmit',0)
            ->select();
        $count = count($stuselect);
        $list=[];
        for($i=0;$i<$count;$i++){
            $ssid = $stuselect[$i]['id'];
            $titleid = $stuselect[$i]['stuid'];
            $titlenum = $this->getCount($titleid);
            if($titlenum>9){
                return 3;
            }
            $list[$i] = [
                'id'        =>  $ssid,
                'issubmit'  =>  1,
                'weigh'     =>  $i
            ];
        }

        $res = Sselect::saveAll($list);

        if($res){
            return 1; //更新成功
        }else{
            return 0; //更新失败
        }
    }

    /**
     * @Description: 显示已经提交的数据
     * @DateTime:    2018/11/27 11:03
     * @Author:      fyd
     */
    public function showSubmit($stuid,$xq,$page,$limit){
        $where['ss.stuid']=$stuid;
//        $where['ss.issubmit']=1;
        $where['ss.belongSenior']=$xq;
        $field="ss.titleid,gt.title,gt.nature,gt.source,gt.isnew,ss.weigh,gt.isprac,ss.isallow,gt.status,gte.teaname,gte.teaphone";
        $alias="ss";
        $join = [
            ['gmis_tapply gt','gt.id=ss.titleid','LEFT'],
            ['gmis_teacher gte','gte.id=ss.teaid','LEFT'],
        ];
        $list = Sselect::alias($alias)
            ->field($field)
            ->join($join)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $list;
    }

    /**
     * @Description: 获取已提交的总数
     * @DateTime:    2018/11/30 5:39
     * @Author:      fyd
     */
    public function countSubmit($stuid,$xq){
        $where['ss.stuid']=$stuid;
//        $where['ss.issubmit']=1;
        $where['ss.belongSenior']=$xq;
        $alias="ss";
        $count = Sselect::alias($alias)
            ->where($where)
            ->count();
        return $count;
    }

    /**
     * @Description: 获取已经通过的
     * @DateTime:    2018/11/27 13:10
     * @Author:      fyd
     */
    public function getAllow($stuid, $xq,$page,$limit){
        $table = "process";
        $alias = "gp";
        $join = [
            ['gmis_tapply gta','gta.id=gp.titleid','LEFT'],
            ['gmis_student gs','gs.id=gp.stuid','LEFT'],
            ['gmis_teacher gte','gte.id=gp.teaid','LEFT']
        ];
        $field = "gta.title,gs.stuidcard,gs.stuname,gs.stuclass,gte.teaname,gte.starttimer,gte.middletimer,gte.replytimer,gte.replyplace,gp.replyscore";
        $where['gp.stuid']=$stuid;
        $where['gp.belongSenior']=$xq;
        $list = Db::name($table)
            ->alias($alias)
            ->field($field)
            ->join($join)
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->select();
        return $list;
    }

    /**
     * @Description: 获取总数
     * @DateTime:    2018/11/30 9:10
     * @Author:      fyd
     */
    public function countAllow($stuid, $xq){
        $table = "process";
        $alias = "gp";

        $where['gp.stuid']=$stuid;
        $where['gp.belongSenior']=$xq;
        $count = Db::name($table)
            ->alias($alias)
            ->where($where)
            ->count();
        return $count;
    }

}