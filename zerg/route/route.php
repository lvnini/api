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

Route::group('api/:version/product',function (){
    Route::get('/recent', 'api/:version.Product/getRecent');
    Route::get('/by_category', 'api/:version.Product/getAllInCategory');
    Route::get('/:id', 'api/:version.Product/getOne',[],['id'=>'\d+']);
});

Route::get('api/:version/category/all', 'api/:version.Category/getAllCategories');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[],['id'=>'\d+']);
Route::get('api/:version/order/by_user', 'api/:version.Order/getOrdersByUser');


Route::post('api/:version/pay/pre_order', 'api/:version.Pay/getPreOrder');

Route::post('api/:version/pay/notify', 'api/:version.Pay/receiveNotify');

return [

];
