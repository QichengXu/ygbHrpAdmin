<?php

namespace app\admin\services\v1;

use app\admin\model\v1\StinmstModel;
use app\admin\validate\v1\StinmstValidate;
use app\common\services\BaseServices;
use app\admin\model\v1\InventoryWarehouseModel;
class InventoryWarehouseService extends BaseServices
{

    /**
     * 添加新的库房库存
     *
     * @return void
     */
    public function insertInventory(){
        (new InventoryWarehouseModel)->insertRecord($this->data['stinmst_data']);
        return $this;
    }

    public function updateInventory($data,$act){


        return $this;
    }

    /**
     * 添加入库主表
     *
     * @return void
     */
    function insertStinmst(){
        (new StinmstModel)->insertRecord($this->data['stinmst_data']);
        return $this;
    }

    /**
     * 添加入库明细
     *
     * @return void
     */
    function insertStindtl($params){
        validate(StinmstValidate::class)
            ->scene('insertStindtl')
            ->check($this->data['stindtl_data']);
        (new StindtlModel)->insertRecord($this->data['stinmst_data']);
        return true;
    }

    /**
     * 添加出库主表
     *
     * @return void
     */
    function addStoutmst($params){
        return true;
    }

    /**
     * 添加出库明细
     *
     * @return void
     */
    function addStoutdtl($params){
        return true;
    }

    /**
     * 添加库存cardabas入库记录
     *
     * @return void
     */
    public function addCardbasRecord($type,$params){
        switch($type){
            case 'RK';
                $res = $this->cardbasRK($params);
                break;
            case 'CK':
                $res = $this->cardbasCK($params);
                break;
            case 'DB':
                $res = $this->cardbasDB($params);
                break;
            case 'PD':
                $res = $this->cardbasPD($params);
                break;
            case 'BS':
                $res = $this->cardbasBS($params);
                break;
            default:

        }
        if(!$res){
            throw new Exception($this->error);
        }
        return $res;
    }
    /**
     * 入库
     *
     * @return void
     */
    protected function cardbasRK($params){
        return true;
    }

    /**
     * 出库
     *
     * @return void
     */
    protected function cardbasCK($params){
        return true;
    }
    /**
     * 调拨
     *
     * @return void
     */
    protected function cardbasDB($params){
        return true;
    }
    /**
     * 盘点
     *
     * @return void
     */
    protected function cardbasPD($params){
        return true;
    }
    /**
     * 报损
     *
     * @return void
     */
    protected function cardbasBS($params){
        return true;
    }

}
