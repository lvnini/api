<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//Route::get('think', function () {
//    return 'hello,ThinkPHP5!';
//});
//Route::get('hello/:name', 'index/hello');

Route::get('api/:version/banner/:id', 'api/:version.banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getSimpleList');

Route::get('api/:version/theme/:id', 'api/:version.Theme/getComplexOne');

Route::get('api/:version/product/recent', 'api/:version.Product/getRecengt');

Route::get('api/:version/product/by_category', 'api/:version.Product/getAllInCategory');

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');


return [

];
