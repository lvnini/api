<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 16:32
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['delete_time','product_id','id'];
}