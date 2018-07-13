<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    /**
     * @url = api/v1/theme?ids=id1,id2,id3,.....
     * @html = GET
     * @return = 一组theme模型
     */
    public function getSimpleList($ids='')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if (!$result){
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id){
        (new IDMustBePostiveInt())->goCheck();
        $result = ThemeModel::getThemeWithProducts($id);
        if (!$result){
            throw new ThemeException();
        }
        return $result;
    }
}
