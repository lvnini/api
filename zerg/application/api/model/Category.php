<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 16:59
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id'];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}