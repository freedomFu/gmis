<?php
namespace app\home\model;
use app\home\model\Tapply;
use app\home\model\Comclass;
use think\Model;
use think\Db;

class Sselect extends Model
{
    //开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

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

    /******************************************************************************************************************/

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
    public function checkSave($stuid){
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
     * @Description: 是否有已经通过允许的
     * @DateTime:    2018/12/1 16:45
     * @Author:      fyd
     */
    public function checkIsAllow($stuid){
        $where['stuid']=$stuid;
        $where['isallow']=1;
        $where['status']='正常';
        $isallow = Sselect::where($where)
            ->find();
        if($isallow){
            return 1;
        }else{
            return 0;
        }
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
            return 4; //已经保存过了
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
//        $where['issubmit']=0;

        $id = Sselect::where($where)
            ->value("id");

        if($id){
            $ss = Sselect::get($id);
            $res = $ss -> delete();
            if($res){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }

    /******************************************************************************************************************/

    /**
     * @Description: 提交数据
     * @DateTime:    2018/11/27 10:51
     * @Author:      fyd
     */
    public function submitData($stuid,$xq,$id){
        $where['status']="正常";
        $where['stuid']=$stuid;
        $where['isallow']=0;
        $where['issubmit']=0;
        $where['belongSenior']=$xq;
        $where['id']=$id;

        $stuselect = Sselect::where($where)
            ->find();

        if($stuselect){
            $titleid = $stuselect['stuid'];
            $titlenum = $this->getCount($titleid);
            if($titlenum>9){
                return 3;
            }
            $updatedata = [
                'issubmit'  =>  1
            ];

            $res = $stuselect->save($updatedata);

            if($res){
                return 1; //更新成功
            }else{
                return 0; //更新失败
            }
        }else{
            return 2; //未找到数据
        }
    }



    /******************************************************************************************************************/

    /**
     * @Description: 获取筛选信息
     * @DateTime:    2018/11/27 10:46
     * @Author:      fyd
     */
    public function showApplyTitle($professid, $titlekey,$senior,$page,$limit){
        $where['gt.belongsenior']=$senior;
        $where['gt.status'] = "已通过";
        $where['gt.stuid'] = null;
        $alias = 'gt';
        $field = "gt.id,gt.title,gt.nature,gt.source,gt.isnew,gt.isprac,gt.proid,gt.status,gte.teaname,gte.teaphone";
        $join = [
            ['gmis_teacher gte','gte.id=gt.teaid','LEFT'],
        ];
        //都没有传入
        if(!($professid==0)){
            $where['proid'] = $professid;
        }
        if(!empty($titlekey)){
            $where['title'] = ['like','%'.$titlekey.'%'];
        }
        $list = Tapply::where($where)
            ->alias($alias)
            ->field($field)
            ->join($join)
            ->order('id desc')
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
     * @Description: 获取筛选信息的总数
     * @DateTime:    2018/12/1 15:39
     * @Author:      fyd
     */
    public function countApplyNum($professid, $titlekey, $senior){
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
     * @Description: 显示已经提交的数据
     * @DateTime:    2018/11/27 11:03
     * @Author:      fyd
     */
    public function showSubmit($stuid,$xq,$page,$limit){
        $where['ss.stuid']=$stuid;
//        $where['ss.issubmit']=1;
        $where['ss.belongSenior']=$xq;
        $field="ss.id,ss.titleid,gt.title,gt.nature,gt.source,gt.isnew,ss.weigh,gt.isprac,ss.isallow,ss.issubmit,gt.status,gte.teaname,gte.teaphone";
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
        $field = "gp.id,gta.title,gs.stuidcard,gs.stuname,gs.stuclass,gte.teaname,gte.starttimer,gte.middletimer,gte.replytimer,gte.replyplace,gp.middlescore,gp.replyscore";
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

    /**
     * @Description: 修改权重
     * @DateTime:    2018/12/1 9:45
     * @Author:      fyd
     */
    public function changeWeigh($id,$weigh){
        $where['id'] = $id;
        $where['isallow'] = 0;
        $where['status'] = "正常";
        $updateData=["weigh"=>$weigh];
        $res = Sselect::get($id);

        if($res){
            $up = $res->where($where)
                ->update($updateData);
            if($up){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 3;
        }
    }

    /******************************************************************************************************************/
}