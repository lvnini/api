<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/13
 * Time: 16:59
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    /**
     * @
     * */
    public function getAllCategories(){
        $catetories = CategoryModel::all([],'img');
        if ($catetories->isEmpty()){
            throw new CategoryException();
        }
        return $catetories;
    }
}