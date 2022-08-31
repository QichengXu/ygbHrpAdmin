<?php
declare (strict_types = 1);

namespace app\admin\validate\v1;

use think\Validate;

class StindtlValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'stock_code'    => 'require',
        'form_seq'      => 'require',
        'item_code'     => 'require',
        'item_name'     => 'require',
        'item_spec'     => 'require',
        'vender_id'     => 'require',
        'form_date'     => 'require',
        'form_user'     => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [
        'stock_code'    => '库房代码必须',
        'item_code'     => '物资编码必须',
        'form_seq'      => '入库单号必须',
        'vender_id'     => '供应商代码必须',
        'form_date'     => '交易日期必须',
        'form_user'     => '操作人员必须',
    ];

    protected $scene = [
        'insertRecord' => ['stock_code','form_seq','vender_id','form_date','form_user'],
    ];
}
