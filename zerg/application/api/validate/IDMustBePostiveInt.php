<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/5
 * Time: 22:39
 */

namespace app\api\validate;


//use think\Validate;

class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPostiveInteger'
    ];

    protected function isPostiveInteger($value, $rule = '', $date = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return $field . '必须为正整数';
        }
    }
}