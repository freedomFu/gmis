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
    public function saveData($dataid){
        $count = count($dataid);

        for($j=0;$j<$count;$j++){
            $data[$j]=[];
        }

        $stuid = session('uid');
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
    public function checkStuTitleNum($dataid){
        $count = count($dataid);
        if($count>3){
            return 2;
        }
        $stuid = session('uid');
        $where['stuid'] = $stuid;
        $num = Db::name('sselect')
            ->where($where)
            ->count();

        $num+=$count;
        dump($num);

        if($num>3){
            return 3;
        }

        return 1;
    }

}