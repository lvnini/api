<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/16
 * Time: 22:34
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\exception\OrerException;
use app\lib\exception\SuccessMessage;

class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'  =>  ['only'=>'placeOrder'],
        'checkPrimaryScope' => ['only'=>'getOrdersByUser,getDetail']
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status =$order->place($uid, $products);
        return $status;
    }

    public function getOrdersByUser($page = 1, $size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrder = OrderModel::getSummaryByUser($uid,$page,$size);
        if ($pagingOrder->isEmpty()){
            return [
              'data' =>[],
              'current_page' => $pagingOrder->getCurrentPage()
            ];
        }
        $data = $pagingOrder->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrder->getCurrentPage()
        ];
    }

    public function getDetail($id){
        (new IDMustBePostiveInt())->goCheck();
        $orderDetail =OrderModel::get($id)->hidden(['prepay_id']);
        if (!$orderDetail){
            throw new OrerException();
        }
        return $orderDetail;
    }

    /**
     * 获取全部订单简要信息（分页）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\lib\exception\ParameterException
     */
    public function getSummary($page=1, $size = 20){
        (new PagingParameter())->goCheck();
//        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])
            ->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }

    public function delivery($id){
        (new IDMustBePostiveInt())->goCheck();
        $order = new OrderService();
        $success = $order->delivery($id);
        if($success){
            return new SuccessMessage();
        }
    }

}