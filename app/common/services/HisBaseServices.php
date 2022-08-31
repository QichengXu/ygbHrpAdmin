<?php

namespace app\common\services;

abstract class HisBaseServices
{
    protected $his_wsdl = '';
    protected $db_conn = null;
    protected $error = '';
    const PATIENT_INFO = 1; 	//病人信息
    const PATIENT_OPERS = 2;	//住院病人手术信息
    const OPERATIONS = 3;	//手术列表
    const FEE_ITEMS = 4;	//收费项目列表
    const FEE_ITEMS_CHOOSE = 5;	//医保or自费
    const EMPL_LIST = 6;	//员工
    const DEPT_LIST = 7;	//科室
    const FYGB = 8;	//费用归并
    const ZYSYFL = 9;	//使用分类

    function __constract(){

    }

    /**
     * 统一调用方法
     * @param $api_no 常量
     * @param array $params
     * @return mixed
     */
    public function hisDataView($api_no,$params=[])
    {
        $this->getDbLink();
        switch($api_no){
            case '1'; //病人信息
                if($params['src_flag'] == 'O'){
                    $result = $this->mzPatient($params['zy_code']);
                }elseif($params['src_flag'] == 'I'){
                    $result = $this->zyPatient($params['zy_code']);
                }
                break;
            case '2'; //住院病人手术信息
                $result = $this->getPatientOperationInfo($params['zy_code']);
                break;
            case '3';	//手术列表
                $operationeffective = $params['operationeffective'] ?: '在用';
                $result = $this->getOperations($params['opr_name'],$operationeffective);
                break;
            case '4';	//收费项目列表
                $result = $this->hisFeeItems($params);
                break;
            case '5';	//医保自费
                $result = $this->hisFeeItemChoose($params['fee_code']);
                break;
            case '6';	//员工
                $result = $this->hospEmployee($params);
                break;
            case '7';	//科室
                $result = $this->hospDepart($params);
                break;
            case '8';	//费用归并
                $result = $this->hisFygb();
                break;
            case '9';	//使用分类
                $result = $this->hisZysyfl();
                break;
        }
        oci_close($this->db_conn);
        if($result === false){
            throw new Exception($this->error);
        }
        return $result;
    }

    abstract protected function mzPatient($patient_id);
    abstract protected function zyPatient($patient_id);
    abstract protected function getPatientOperationInfo($patient_id);
    abstract protected function getOperations($opr_name='',$fective);
    abstract protected function hisFeeItems($params);
    abstract protected function hisFeeItemChoose($fee_code);
    abstract protected function hospEmployee($params);
    abstract protected function hospDepart($params);
    abstract protected function hisFygb();
    abstract protected function hisZysyfl();
    abstract protected function getDbLink();

}
