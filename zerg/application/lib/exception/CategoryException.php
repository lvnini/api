<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 17:10
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = "请求的目录不存在，请检查参数";
    public $errorCode = 50000;
}