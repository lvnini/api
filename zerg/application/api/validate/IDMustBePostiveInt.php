<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/5
 * Time: 22:39
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger'
    ];
    protected $message = [
        'id' => 'id必须为正整数'
    ];
}