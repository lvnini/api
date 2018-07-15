<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 19:59
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = "用户不存在";
    public $errorCode = 60000;
}