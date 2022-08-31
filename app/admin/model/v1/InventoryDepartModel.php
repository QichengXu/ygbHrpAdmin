<?php

namespace app\admin\model\v1;

use think\Model;

class InventoryDepartModel extends Model
{

    public function getStatusAttr($value)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$value];
    }
}
