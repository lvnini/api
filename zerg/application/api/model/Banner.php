<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/12
 * Time: 21:44
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden = ['delete_time','update_time'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {
        $banner = self::with('items.img')->find($id);
        return $banner;
    }
}