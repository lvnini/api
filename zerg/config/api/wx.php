<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/15
 * Time: 00:12
 */

return [
    // 小程序app_id
    'app_id' => 'wx0ccf547dcbb79130',
    // 小程序app_secret
    'app_secret' => 'b21d3979d86088ee876b64e62635f4f4',
    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?'.
        'appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",
];