<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 15:34
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\model\Product as ProductModexl;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecengt($count=15){
        (new Count())->goCheck();
        $products = ProductModexl::getMostRecent($count);
        if ($products->isEmpty()){
            throw new ProductException();
        }
        $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModexl::getProductsByCategoryID($id);
        if ($products->isEmpty()){
            throw new ProductException();
        }
        $products->hidden(['summary']);
        return $products;
    }
}