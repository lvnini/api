<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/8/1
 * Time: 18:04
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'as' =>'require|isNotEmpty',
        'se' => 'require|isNotEmpty',
    ];
}