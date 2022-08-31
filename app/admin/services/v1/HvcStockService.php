<?php

namespace app\admin\service\v1;

use app\admin\model\v1\HighvalueStorage;
class HvcStockService extends \app\common\services\BaseServices
{

    /**
     * 增加库存
     * @param array $list
     */
    function addHvcStorage(array $list){
        $hvcs_model = new HighvalueStorage();
        $list = $hvcs_model->createData($list);
        $new_id = $hvcs_model->saveAll($list);

        return $new_id;

    }
}
