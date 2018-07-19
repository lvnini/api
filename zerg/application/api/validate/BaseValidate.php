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

    protected function isPositiveInteger($value, $rule = '', $date = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result){
            return true;
        }else{
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

    public function getDataByRule($arrays){
        if (array_key_exists('user_id',$arrays) | array_key_exists('uid',$arrays)){
            //不允许包含user_id与uid, 防止恶意覆盖
            throw new ParameterException([
               'msg' => '参数中包含非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }

}