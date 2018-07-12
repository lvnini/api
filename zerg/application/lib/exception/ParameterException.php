<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/12
 * Time: 17:40
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = "参数错误";
    public $errorCode = 10000;
}