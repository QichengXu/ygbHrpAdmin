<?php

namespace app\admin\services\v1;

use app\common\services\HisBaseServices;

/**
 * 温附口腔医院
 */
class WkqHisServiceService extends HisBaseServices
{
    protected $his_wsdl = 'http://168.168.1.41:8088/hospitalservice/services/webService?wsdl';
    function __constract(){
        parent::__constract();
    }

    protected function mzPatient($patient_id){
        if(!$patient_id){
            $this->error = '请输入病人ID';
            return false;
        }
        $sql = "SELECT * FROM v_patient_O WHERE PATIENTID = {$patient_id}";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $data  =  oci_fetch_array ( $oci_query , OCI_ASSOC );
        if($data == false){
            $this->error = '未查询到病人相关信息';
            return false;
        }
        $info = [
            'opename'=> $data['PATIENTNAME'],                 // 病人姓名
            'sex'=> $data['PATIENTSEX'] == '男' ? 10 : 11,  //性别 TODO试图里没有
            'age'=> getAgeByBirth(substr($data['PATIENTBIRDAY'],0,10),2), 			//年龄
            'phone'=> $data['PATIENTPNR'],                   //手机号码
            'address'=> $data['PATIENTADSN'],              //居住地址
            'certificatenumber'=> $data['PATIENTCARDN'],    //证件号码
            'charge_type'=> $data['PATIENTCHARNAME'],    //医保性质
            'br_type'=> $data['TYPE'],
        ];
        oci_free_statement($oci_query);  //释放资源
        return $info;
    }

    protected function zyPatient($patient_id){
        if(!$patient_id){
            $this->error = '请输入病人ID';
            return false;
        }
        $sql = "SELECT * FROM v_patient_I WHERE PATIENTID = {$patient_id}";

        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $data  =  oci_fetch_array ( $oci_query , OCI_ASSOC );
        if($data == false){
            $this->error = '未查询到病人相关信息';
            return false;
        }
        if(!$data['PATIENTBIRDAY']){
            $birthday = substr($data['PATIENTCARD'],6,4).'-'.substr($data['PATIENTCARD'],10,2).'-'.substr($data['PATIENTCARD'],12,2);
        }else{
            $birthday = substr($data['PATIENTBIRDAY'],0,10);
        }
        $info = [
            'opename'=> $data['PATIENTNAME'],                 // 病人姓名
            'sex'=> $data['PATIENTSEX'] == '男' ? 10 : 11,  //性别 TODO试图里没有
            'age'=> getAgeByBirth($birthday,2), //年龄
            'phone'=> $data['PATIENTPHONE'],                   //手机号码
            'address'=> $data['PATIENTADS'],              //居住地址 TODO试图里没有
            'certificatenumber'=> $data['PATIENTCARD'],    //证件号码
            //'br_type'=> $data['TYPE'],
            'wardnum' =>  $data['PATIENTDAPARTCODE'],  //病区代码
            'ry_date'=> $data['PATIENTINDATE'],  //入院时间
            'bedblocknum'=> $data['PATIENTBEDCODE'],  //床号
            'jzksdm'=> $data['PATIENTAREACODE'],  //接诊科室代码
            'jzksmc'=> '',
            'charge_type'=>$data['PATIENTCHARNAME'],  //医保性质
            'in_hosp'=> $data['PATIENTCONDITION'], //是否在院
        ];
        if($data['PATIENTDAPARTCODE']){
            $dept = $this->hospDept(['depatcode'=>$data['PATIENTDAPARTCODE']]);
            $info['wardnum_name'] = $dept[0]['depatname']; //病区名称
        }
        oci_free_statement($oci_query);  //释放资源
        return $info;
    }

    //病人手术列表
    protected function getPatientOperationInfo($patient_id)
    {
        if(!$patient_id){
            $this->error = '请输入病人ID';
            return false;
        }
        $sql = "SELECT OPERATIONSQD,OPERATIONCODE,OPERATIONNAME,OPERATIONZT,OPERATIONDIAGNOSIS,DIAGNOSISNAME,OPERATIONDOCTOR,DOCTORNAME,SQDEPATNAME,SQDEPATCODE, TO_CHAR(OPERATIONDATE,'yyyy-mm-dd hh24:mi:ss') as SSDATE from v_patient_operation_list where patient ='{$patient_id}'";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $opr_list = [];

        while( ($row = oci_fetch_array($oci_query)) != false ){
            // DUMP($row);
            $opr_list[] = [
                'opdate' =>$row['SSDATE'], //手术日期
                'ss_date' =>date('Y-m-d',strtotime($row['SSDATE'])),//手术日期
                'ss_code' => $row['OPERATIONCODE'],//手术代码
                'ss_name' => $row['OPERATIONNAME'],//手术名称
                'ss_zt'=>$row['OPERATIONZT'],//手术状态
                'jbmc'=>$row['DIAGNOSISNAME'], //疾病名称
                'operrdn' => $row['OPERATIONDIAGNOSIS'],
                'yisheng_code'=>$row['OPERATIONDOCTOR'], //主刀医生
                'zd_yisheng'=>$row['DOCTORNAME'], //主刀医生
                'operation_apply_id'=>$row['OPERATIONSQD'],
                'ordered_by_name' => $row['SQDEPATNAME'],
                'ordered_by_id'=> $row['SQDEPATCODE'],
            ];

        }
        oci_free_statement($oci_query);  //释放资源
        return $opr_list;
    }


    //手术列表
    protected function getOperations($opr_name='',$operationefective = '在用'){
        $sql = "SELECT operationcode,operationname,operationpy,operationeffective FROM v_operation_list WHERE operationeffective = '{$operationefective}'";
        if($opr_name !== ''){
            $opr_name = trim($opr_name);
            $sql .= " AND ( operationname like '%{$opr_name}%' or operationpy like '%{$opr_name}%')";
        }
        //echo $sql;
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $opr_list = [];
        while( ($row = oci_fetch_array($oci_query)) != false ){
            $opr_list[] = [
                'operationcode' => $row['OPERATIONCODE'],
                'operationname' => $row['OPERATIONNAME'],
                'operationpy' => $row['OPERATIONPY'],
                'operationeffective' => $row['OPERATIONEFFECTIVE'],
            ];
        }
        oci_free_statement($oci_query);  //释放资源
        return $opr_list;
    }

    //获取his收费项目
    protected function hisFeeItems($params){
        $sql = "SELECT * from v_items_list";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $list = [];
        while( ($row = oci_fetch_assoc($oci_query)) != false ){
            $list[] = $row;
        }
        oci_free_statement($oci_query);  //释放资源
        return $list;
    }

    //医保 or 自费
    protected function hisFeeItemChoose($fee_code){
        $sql = "SELECT * from v_Items_choose where itemscode = {$fee_code}";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $list = [];
        while( ($row = oci_fetch_array($oci_query)) != false ){
            //DUMP($row);
            $list[] = [
                'itemcode' =>$row['ITEMSCOCE'],
                'itemname' =>$row['ITEMSNAME'],
                'itemschoose' =>$row['ITEMSCHOOSE'],
            ];
        }
        oci_free_statement($oci_query);  //释放资源
        return $list;
    }

    //员工
    protected function hospEmployee($map = []){

    }

    //7、科室
    protected function hospDepart($map = []){
        $sql = "SELECT * from v_depat_list";
        $where = [];
        foreach($map as $key => $val){
            switch($key){
                case 'depatcode':
                    $where[] = $key .'='. $val;
                    break;
                case 'depatname':
                    $where[] = "{$key} like '%{$val}%'";
                    break;
            }
        }
        if(count($where) > 0){
            $where_str = implode(' and ',$where);
            $sql .= " where {$where_str}";
        }
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $dept_list = [];

        while( ($row = oci_fetch_array($oci_query)) != false ){
            //DUMP($row);
            $dept_list[] = [
                'depatcode' =>$row['DEPATCODE'],
                'depatname' =>$row['DEPATNAME'],
                'depatpydm' =>$row['DEPATPYDM'],
            ];
        }
        oci_free_statement($oci_query);  //释放资源
        return $dept_list;
    }

    //8、费用归并
    protected function hisFygb(){
        $sql = "SELECT * from v_item_fygb";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $list = [];
        while( ($row = oci_fetch_assoc($oci_query)) != false ){
            $list[] = $row;
        }
        oci_free_statement($oci_query);  //释放资源
        return $list;
    }

    //9、使用分类
    protected function hisZysyfl(){
        $sql = "SELECT * from v_items_zysyfl where DMSB IN (25,26,27)";
        $oci_query = oci_parse( $this->db_conn ,$sql);
        oci_execute ( $oci_query );
        $list = [];
        while( ($row = oci_fetch_assoc($oci_query)) != false ){
            $list[] = $row;
        }
        oci_free_statement($oci_query);  //释放资源
        return $list;
    }

    protected function getDbLink(){
        $username='YGB_USER';			    //数据库用户名
        $password='123';		    //数据库密码
        $server='168.168.1.18/hrp';	    //ip地址或服务器名
        $this->db_conn = oci_connect($username,$password,$server,'utf8');
        if(!$this->db_conn){
            throw new Exception('数据库连接失败!请联系管理员！');
        }
    }

}
