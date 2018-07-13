<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 15:38
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule =[
      'count' =>'isPostiveInteger|between:1,15'
    ];

    protected $message = [
        'count' => 'count参数必须是1到15的之间'
    ];
}