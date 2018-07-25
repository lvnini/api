<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/23
 * Time: 01:01
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //待支付
    const UNPAID = 1;

    //已支付
    const PID = 2;

    //已发货
    const DELIVERED = 3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;

}