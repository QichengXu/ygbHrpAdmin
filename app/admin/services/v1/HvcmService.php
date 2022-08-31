<?php

namespace app\admin\service\v1;

use app\admin\model\HighvalueStorage;
use app\admin\BaseService;
use think\Exception;

/**
 *
 */
class HvcmService extends BaseService
{

    /*
	 * 刷主条码进行后台查询
	 */
    function mtrlBarcodeQuery($bar_code,$item_code = ''){
        $where = [
            ['card_ctl','=', 2],
            ['disabled','=', 'N'],
            ['bar_code','like', '%'.$bar_code.'%'],
        ];
        if($item_code){
            $where[] = ['item_code','=', $item_code];
        }
        $mtrlmst = Db::name('Mtrlmst');
        $mtr_info = $mtrlmst->where([$where])->order('card_ctl desc')->select()->toArray();
        if(empty($mtr_info)){
            throw new Exception('未查询到物资信息');
        }
        if(count($mtr_info) > 1){
            return ['mult_flag'=>true,'item_list'=>$mtr_info];
        }

        $ca_no_list = Db::name('Mtrlcano')->field('id,lc_name,expire_date')->where([
            ['item_code','=',$mtr_info[0]['item_code']],
            ['lc_type','=', 2],
            ['disabled','=', 0],
        ])->group('lc_name')->select()->toArray();
        if(!empty($caNOList)){
            $mtr_info[0]['caNoList'] = $ca_no_list;
        }else{
            $mtr_info[0]['caNoList']= [
                ['lc_name'=>$mtr_info[0]['ca_no']]
            ];
        }
        echo json_encode($mtr_info[0]);
    }
}
