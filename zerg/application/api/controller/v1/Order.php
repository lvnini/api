<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/16
 * Time: 22:34
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'  =>  ['only'=>'placeOrder'],
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status =$order->place($uid, $products);
        return $status;
    }
}