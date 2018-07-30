<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 17:46
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{

    protected $beforeActionList = [
        'checkPrimaryScope'  =>  ['only'=>'createorupdateaddress,getUserAddress'],
    ];

    public function createOrUpdateAddress(){
//        (new AddressNew())->goCheck();
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if (!$user){
            throw new UserException();
        }

        $dtaArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;
        if (!$userAddress){
            $user->address()->save($dtaArray);
        }else{
            $user->address->save($dtaArray);
        }
        return json(new SuccessMessage(), 201);
    }

    /**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }
}