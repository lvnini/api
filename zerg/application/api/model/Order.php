<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/19
 * Time: 00:55
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

    protected $autoWriteTimestamp = true;
}