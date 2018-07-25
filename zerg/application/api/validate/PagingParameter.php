<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/25
 * Time: 16:31
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];

    protected $message =[
        'page' => '分页参数必须为正整数',
        'size' => '分页参数必须为正整数'
    ];
}