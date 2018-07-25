<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/22
 * Time: 23:23
 */

namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrerException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModer;
use app\api\service\Order as OrderService;

require '../extend/WxPay/WxPay.Api.php';
//require "../extend/WxPay/WxPay.Config.php";

use think\facade\Log;

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID){
            throw new Exception('订单不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay(){
        $this->chekOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if (!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice){
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零售商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetProduct_id($this->orderNO);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData){
        $config = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config,$wxOrderData);
        if ($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] != 'SUCCESS')
        {
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);
        $signature =$this->sign($wxOrder);
        return $signature;
    }

    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config(wx.api_id));
        $jsApiPayData->SetTimeStamp((string)time());

        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id ='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');

        $sign = $jsApiPayData->MakeSign();
        $rawValues =$jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }

    private function recordPreOrder($wxOrder){
        OrderModer::where('id','=',$this->orderID)
            ->Update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    private function chekOrderValid(){
        $order = OrderModer::where('id','=',$this->orderID)
            ->find();
        if (!$order){
            throw new OrerException();
        }
        if(!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID){
            throw new OrerException([
                'msg' => '订单已支付了',
                'errorCode' => 80003,
                'Code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}