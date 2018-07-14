<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/6
 * Time: 09:06
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $params = input('');
        $result = $this->batch()->check($params);
        if (!$result){
            $e = new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        }else{
            return true;
        }
    }

    protected function isPostiveInteger($value, $rule = '', $date = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isNotEmpty($value, $rule = '', $date = '', $field = '')
    {
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }

}