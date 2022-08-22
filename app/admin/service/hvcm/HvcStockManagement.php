<?php

namespace app\admin\service\hvcm;

use app\admin\model\HighvalueStorage;
class HvcStockManagement extends HvcmService
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
