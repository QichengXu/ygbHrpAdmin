<?php
declare( strict_types = 1 );
/**
 * author      : zhyzkl
 * createTime  : 2021/11/6 9:59 上午
 * description :
 */

namespace app\common\model;

use think\Model;
use app\common\model\lib\EnhanceModelsBaseClasses;

abstract class BaseModel extends Model
{
    use EnhanceModelsBaseClasses;

    public function insertRecord( array $data ) :?int {
        $this->save( $data );
        return $this->id;
    }


}