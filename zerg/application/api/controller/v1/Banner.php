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
    /**
     * 获取Banner图片资料
     * @url = /api/v1/banner/:id
     * @id = bang的id号
     * @http = GET请求
     *
     * */
    public function getBanner($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
//        $banner->hidden(['delete_time']); //只影藏
//        $banner->visible(['id']); //只显示
        if (!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}