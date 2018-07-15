<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 16:31
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['delete_time','product_id','img_id'];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}