<?php

namespace app\admin\controller\v1;

use app\common\controller\BaseController;
use app\admin\services\v1\InventoryWarehouseService;
use app\helpers\SystemEnum;
use think\App;
/**
 * 仓库库房库存管理
 */
class InventoryWarehouseController extends BaseController
{
//    protected $inve_ware_ser;
//
//    public function __construct(InventoryWarehouseService $inve_ware_ser)
//    {
//        parent::__construct(new App());
//        $this->inve_ware_ser = $inve_ware_ser;
//    }
    /**
     * @param
     */
    public function addNewInventory(InventoryWarehouseService $inve_ware_ser){
        $inve_ware_ser->setData('stinmst_data',$this->param);
        $inve_ware_ser->insertStinmst()->insertStindtl()->insertCardbas()->addInventory();
        return $this->success(SystemEnum::REQUEST_SUCCESS,'',[]);
    }

    /**
     * 更新库房库存
     *
     * @return void
     */
    public function updateInventory(){

    }

    /**
     * 添加库房库存
     *
     * @return void
     */
    public function queryInventory(){

    }

}
