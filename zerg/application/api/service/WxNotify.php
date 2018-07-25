<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/25
 * Time: 11:58
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\facade\Log;

require '../extend/WxPay/WxPay.Api.php';

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($objData, $config, &$msg)
    {
       if ($objData['result_code'] == 'SUCCESS'){
           $orderNo = $objData['out_trade_no'];
           Db::startTrans();
           try{
               $order = OrderModel::where('order_no','=', $orderNo)->find();
               if ($order->status == 1){
                   $service = new OrderService();
                   $stockStatus = $service->checkOrderStock($order->id);
                   if ($stockStatus['pass']){
                       $this->updateOrderStatus($order->id,true);
                       $this->reduceStock($stockStatus);
                   }else{
                       $this->updateOrderStatus($order->id,false);
                   }
               }
               Db::commit();
               return true;
           }
           catch (Exception $ex){
               Db::rollback();
               Log::error($ex);
               return false;
           }
       }else{
           return true;
       }
    }

    private function reduceStock($stockStatus){
        foreach ($stockStatus['pStatusArray'] as $singlePstatus){
            Product::Where('id','=',$singlePstatus['id'])
                ->setDec('stock',$singlePstatus['count']);
        }
    }

    private function updateOrderStatus($orderID,$success){
        $status = $success?OrderStatusEnum::PID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id','=',$orderID)->update(['status' => $status]);
    }
}