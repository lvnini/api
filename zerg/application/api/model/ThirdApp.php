<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/8/1
 * Time: 18:09
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac, $se)
    {
        $app = self::where('app_id','=',$ac)
            ->where('app_secret', '=',$se)
            ->find();
        return $app;
    }
}