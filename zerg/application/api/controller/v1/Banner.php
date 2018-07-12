<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/5
 * Time: 21:51
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use app\api\model\Banner as BannerModel;

class Banner
{
    public function getBanner($id)
    {
        (new IDMustBePostiveInt())->goCheck();

        $banner = BannerModel::get($id);
        if (!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}