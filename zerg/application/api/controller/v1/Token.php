<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/14
 * Time: 23:14
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code = ''){
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut -> get();
        return [
            'token' => $token
        ];
    }
}