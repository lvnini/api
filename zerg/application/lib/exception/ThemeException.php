<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 13:44
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 400;
    public $msg = "指定的主题不存在，请检查主题ID";
    public $errorCode = 30000;
}