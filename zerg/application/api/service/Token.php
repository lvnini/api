<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 04:04
 */

namespace app\api\service;


class Token
{
    public static function generateToke(){
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }
}