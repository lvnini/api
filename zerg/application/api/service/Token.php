<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 04:04
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    public static function generateToke()
    {
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');

        return md5($randChars . $timestamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}