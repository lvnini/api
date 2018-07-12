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
}