<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/8
 * Time: 16:06
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = "请求的Banner不存在";
    public $errorCode = 40000;
}