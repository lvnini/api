<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/17
 * Time: 09:40
 */

namespace app\lib\exception;


class OrerException extends BaseException
{
    public $code = 404;
    public $msg = "订单不存在，请检查ID";
    public $errorCode = 80000;
}