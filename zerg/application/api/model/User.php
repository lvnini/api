<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/14
 * Time: 23:23
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }
}