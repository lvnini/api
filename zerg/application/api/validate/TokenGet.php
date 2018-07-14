<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/14
 * Time: 23:15
 */

namespace app\api\validate;


class TokenGet extends  BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message =[
        'code' => '请传输code来获取Toke'
    ];
}