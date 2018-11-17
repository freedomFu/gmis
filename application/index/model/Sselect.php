<?php
/**
 * @Author:      fyd
 * @DateTime:    2018/11/15 21:48
 * @Description: 描述信息
 */

namespace app\index\model;
use app\index\model\Tapply;
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

    public function sselect($teaid){
        $list = Sselect::order('id desc')
            ->where('teaid',$teaid)
            ->paginate(10);
        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:15
     * @Description: 获取筛选信息
     */
    public function showApplyTitle($professid, $titlekey,$senior){
        $where['belongsenior']=$senior;
        $where['status'] = "已通过";
        //都没有传入
        if(!($professid==0)){
            $where['proid'] = $professid;
        }

        if(!empty($titlekey)){
            $where['title'] = ['like','%'.$titlekey.'%'];
        }

        $list = Tapply::where($where)
            ->order('id desc')
            ->select();

        return $list;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 10:45
     * @Description: 根据专业id获取专业名称
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
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:35
     * @Description: 获取当前题目总数
     */
    public function getCount($titleid){
        $where['titleid'] = $titleid;
        $where['issubmit'] = 1; //已经提交
        $where['status'] = "正常";
        $total = Db::name('sselect')
            ->where($where)
            ->count();
        return $total;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 16:01
     * @Description: 根据titleid获取teaid
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
     * @Author:      fyd
     * @DateTime:    2018/11/17 15:53
     * @Description: 保存数据，但是没有提交，获取的是titleid，已经通过的
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
     * @Author:      fyd
     * @DateTime:    2018/11/17 17:10
     * @Description: 判断是否还可以申请
     */
    public function checkStuTitleNum($stuid,$dataid){
        //若已经有提交的就不能再添加了
        $wherecheck['stuid'] = $stuid;
        $wherecheck['issubmit']=1;
        $checkIsAllow = Sselect::where($wherecheck)
            ->find();
        if($checkIsAllow){
            return 4;
        }

        $count = count($dataid);
//        dump($count);
        if($count>3){
            return 2;
        }
//        dump($stuid);
        $where['stuid'] = $stuid;
        $num = Sselect::where($where)
            ->count();
//        dump($num);

        $num+=$count;
//        dump($num);

        if($num>3){
            return 3;
        }
        return 1;
    }

    /**
     * @Author:      fyd
     * @DateTime:    2018/11/17 20:03
     * @Description: 提交数据
     */
    public function submitData($stuid){

        $wherecheck['stuid'] = $stuid;
        $wherecheck['issubmit']=1;
        $checkIsAllow = Sselect::where($wherecheck)
            ->find();
        if($checkIsAllow){
            return 4;
        }

        $where['stuid'] = $stuid;
        $stuselect = Sselect::where($where)
            ->select();
        $count = count($stuselect);

        if($count>3){
            return 2; //超过三个，提示出错
        }

        for($i=0;$i<$count;$i++){
            $ssid = $stuselect[$i]['id'];
            $titleid = $stuselect[$i]['stuid'];
            $titlenum = $this->getCount($titleid);
            if($titlenum>9){
                return 3;
            }
            $list[$i] = [
                'id'        =>  $ssid,
                'issubmit'  =>  1
            ];
        }
        $res = Sselect::saveAll($list);

        if($res){
            return 1; //更新成功
        }else{
            return 0; //更新失败
        }
    }

}