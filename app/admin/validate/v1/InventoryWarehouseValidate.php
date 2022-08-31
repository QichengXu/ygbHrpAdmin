<?php
declare (strict_types = 1);

namespace app\admin\validate\v1;

use think\Validate;

class InventoryWarehouseValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'stock_code'    => 'require',
        'card_id'       => 'require',
        'form_id'       => 'require',
        'form_seq'      => 'require',
        'item_code'     => 'require',
        'rk_qty'        => 'require',
        'stk_qty'       => 'require',
        'price'         => 'require',
        'vender_id'     => 'require',
        'vender_name'   => 'require',
        'valid_date'    => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'stock_code' => '库房必须',
        'item_code' => '物资编码必须',
    ];

    protected $scene = [
        'insertInventory'  =>  ['form_id'],
    ];
}
