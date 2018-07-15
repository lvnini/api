<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 21:44
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden =['id','delete_time','user_id'];
}