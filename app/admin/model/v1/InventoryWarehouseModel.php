<?php

namespace app\admin\model\v1;

use app\common\model\BaseModel;
use app\common\model\lib\EnhanceModelsBaseClasses;
class InventoryWarehouseModel extends BaseModel
{
    use EnhanceModelsBaseClasses;
    protected $name = 'InventoryWarehouse';
    public function getStatusAttr($value)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$value];
    }

}
