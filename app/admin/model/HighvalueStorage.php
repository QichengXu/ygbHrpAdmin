<?php

namespace app\admin\model;

use Think\Model;
class HighvalueStorage extends Model
{

    function createData($list){
        foreach ($list as &$item){
//            $item[''] = '';
        }
        return $list;
    }
}
