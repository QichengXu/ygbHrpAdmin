<?php

namespace app\admin\model\v1;

use app\admin\validate\v1\StinmstValidate;
use app\common\model\BaseModel;

class StinmstModel extends BaseModel
{
    protected $name = 'Stinmst';

    public function insertRecord(array $data): ? int
    {
        $data['form_date'] = date('Y-m-d');

        return parent::insertRecord($data);
    }

    public function getStatusAttr($value)
    {
        $status = [0=>'禁用',1=>'正常'];
        return $status[$value];
    }

}
