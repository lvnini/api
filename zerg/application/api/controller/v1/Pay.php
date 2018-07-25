<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/22
 * Time: 23:10
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePostiveInt;
use app\api\service\Pay as PayService;

require "../extend/WxPay/WxPay.Config.php";

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'  =>  ['only'=>'getPreOrder'],
    ];

    public function getPreOrder($id=''){
        (new IDMustBePostiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify(){
        $config = new \WxPayConfig();
        $notify = new WxNotify();
        $notify->Handle($config);

        //转发机制用于调试
//        $xmlData = file_get_contents('php://input');
//        $result = curl_post_raw('http:/z.cn/api/v1/pay/receiveNotify?XDEBUG_SESSION_START=11965', $xmlData);
//        return $result;
    }
}