<?php
declare (strict_types = 1);

namespace app\admin\validate\v1;

use think\Validate;

class StinmstValidate extends Validate
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
        'stock_code'    => '入库主单库房代码必须',
        'form_seq'      => '入库单号必须',
        'vender_id'     => '入库主单供应商代码必须',
        'form_date'     => '入库主单交易日期必须',
        'form_user'     => '入库主单操作人员必须',
    ];

    protected $scene = [
        'insertRecord' => ['stock_code','form_seq','vender_id','form_date','form_user'],
    ];
}
