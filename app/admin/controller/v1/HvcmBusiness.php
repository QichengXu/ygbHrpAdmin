<?php

namespace app\admin\controller\v1;

use app\common\controller\BaseController;
use app\admin\service\v1\HvcmService;
use think\Exception;

/**
 * 高值耗材管理
 */
class HvcmBusiness extends BaseController
{
    function mtrlBarcodeQuery(HvcmService $hvcm_service){
        try {
            if(!isset($this->params['bar_code']) || $this->params['bar_code'] == ''){
                throw new Exception('未输入条形码');
            }
            $hvcm_service->mtrlBarcodeQuery($this->params['bar_code'],);
        } catch (Exception $e) {
            return json();
        }
    }


    //寄售物资接收操作
    function consignGoodsReceive(){
        $model = Db::name('HighvaluePobill');
        $cardbas = Db::name('HighvalueCardbas');
        $mtrlmst = Db::name('Mtrlmst');
        $po_pms = array();
        $model->startTrans();
        $po_list = $model->where([
            ['id','in',$this->params['id_arr']],
            ['check_state','=',1],
            ['send_state','=',2],
            ['qs_state','=',0],
        ])->select()->toArray();
        if($this->params['act'] == 1){  //接收
            $save['qs_state'] = 1;
            $save['qs_time'] = date('Y-m-d H:i:s');
            $save['qs_user'] = $this->params['account'];
            $save['ps_flag'] = 2;
            //临床库房增加库存
            foreach ($po_list as $po){
                $save['qs_num'] = $po['send_qtys'];
                $res = $model->where('id',$po['id'])->save($save);
                if($po['state'] != 1){	//为1的是接收后需要入库的
                    if($po['state'] == 0){
                        $model->where("id = '".$po['id']."'")->setField('state',2);
                    }
                    continue;
                }
                $card_id = $cardbas->addCardByPobill($po); //todo
                if(!$card_id){
                    $model->rollback();
                    return false;
                }
                //增加库存
                $highvalue_storage = D('HighvalueStorage');
                $stock_add = $highvalue_storage->addStockStorage($card_id); //todo
                if(!$stock_add){
                    $model->rollback();

                    $this->err_msg = $highvalue_storage->getError(); //todo
                    return false;
                }
                $model->where([
                    ["id",'=',$po['id']],
                ])->setField('state',2);
                if($po['send_id']) {
                    $po_pms[$po['po_id']] = $po['send_seq'];
                }
            }
            $mapupmtr['pur_date']=date('Y-m-d');
            $mtrlmst->where("item_code='".$po['item_code']."'")->save($mapupmtr);
            if(count($po_pms) > 0){
                import("ORG.Util.API");
                $api = new API();
                $api->getUpdateHighPobill($po_pms);
                //if($res == 'error'){
                //$cardbas->rollback();
                //	Log::write('寄售物资接收失败,外网更新失败');
                //return false;
                //}
            }
        }elseif ($_POST['act'] == 2){ //拒接
            $save['state'] = -1;
            $save['send_state'] = 3;
            $save['ps_flag'] = 2;
            $save['qs_state'] = 2;
            $save['qs_time'] = date('Y-m-d H:i:s');
            $save['qs_user'] = $_SESSION['account'];
            $remarks = $_SESSION['loginUserName'].'于'.date('Y-m-d H:i:s').'进行了拒绝签收操作。原因是：'.$_POST['remarks'];
            $save['remarks'] = $remarks;
            $save['return_remarks'] = $remarks;
            $res = $model->where($map)->save($save);
            if(!$res){
                $model->rollback();
                return $res;
            }
            foreach ($po_list as $po){

                if($po['send_id']) {
                    $po_pms[$po['po_id']] = $po['send_seq'];
                }
            }
            if(count($po_pms) > 0){
                //import("ORG.Util.API");
                //$api = new API();
                //$api->getUpdateHighPobill($po_pms,'',2, $remarks); //todo
            }
        }
        $model->commit();
        return $res;
    }
}
