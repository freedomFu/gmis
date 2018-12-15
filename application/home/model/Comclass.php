<?php
/**
 * @Description: 公共Model类
 * @DateTime:    2018/12/15 8:23
 * @Author:      fyd
 */
namespace app\home\model;
use think\Model;
use think\Db;

class Comclass extends Model
{


    /**
     * @Description: 获取enum值
     * @DateTime:    2018/12/15 8:25
     * @Author:      fyd
     */
    private function getEnum($tablename, $name){
        $sql = "show columns from ".$tablename." like '".$name."';";
        $res = Db::query($sql);
        return $res;
    }

    /**
     * @Description: 获取数组
     * @DateTime:    2018/12/15 8:32
     * @Author:      fyd
     */
    private function getArray($res){
        $str = $res[0]['Type'];
        $typestr = getNeedBetween($str,'(',')');
        $typestr = str_replace("'","",$typestr);
        $typearr = explode(",",$typestr);
        return $typearr;
    }


    /**
     * @Description: 分别获取enum值，并获取最后数组
     * @DateTime:    2018/12/15 8:25
     * @Author:      fyd
     */
    public function getTeaHonor(){
        $res = $this->getEnum("gmis_teacher","teahonor");
        $typearr = $this->getArray($res);
        return $typearr;
    }

    public function getTeaDuty(){
        $res = $this->getEnum("gmis_teacher","teaduty");
        $typearr = $this->getArray($res);
        return $typearr;
    }

    public function getMidScore(){
        $res = $this->getEnum("gmis_process","middlescore");
        $typearr = $this->getArray($res);
        return $typearr;
    }

    public function getRepScore(){
        $res = $this->getEnum("gmis_process","replyscore");
        $typearr = $this->getArray($res);
        return $typearr;
    }


    /**
     * @Description: 获取课题性质或者来源名称
     * @DateTime:    2018/12/15 16:46
     * @Author:      fyd
     */
    public function getTeaName($table, $id){
        $where['id'] = $id;
        $name = Db::name($table)
            ->where($where)
            ->value("name");
        return $name;
    }
}