<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/8/1
 * Time: 22:39
 */

namespace app\api\service;


use app\lib\exception\OrerException;

class DeliveryMessage extends WxNotify
{
    const DELIVERY_MSG_ID ='你的模板ID';// 小程序模板消息ID号

    public function sendDeliveryMessage($order, $tplJumpPage = '')
    {
        if (!$order) {
            throw new OrerException();
        }
        $this->tplID = self::DELIVERY_MSG_ID;
        $this->formID = $order->prepay_id;
        $this->page = $tplJumpPage;
        $this->prepareMessageData($order);
        $this->emphasisKeyWord='keyword2.DATA';
        return parent::sendMessage($this->getUserOpenID($order->user_id));
    }

    private function prepareMessageData($order)
    {
        $dt = new \DateTime();
        $data = [
            'keyword1' => [
                'value' => '顺风速运',
            ],
            'keyword2' => [
                'value' => $order->snap_name,
                'color' => '#27408B'
            ],
            'keyword3' => [
                'value' => $order->order_no
            ],
            'keyword4' => [
                'value' => $dt->format("Y-m-d H:i")
            ]
        ];
        $this->data = $data;
    }

    private function getUserOpenID($uid)
    {
        $user = User::get($uid);
        if (!$user) {
            throw new UserException();
        }
        return $user->openid;
    }
}