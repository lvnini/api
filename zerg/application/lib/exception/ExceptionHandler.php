<?php
/**
 * Created by PhpStorm.
 * User: lvnini
 * Date: 2018/7/8
 * Time: 15:56
 */

namespace app\lib\exception;

use think\exception\Handle;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    public $code;
    public $msg;
    public $errorCode;

    //需要返回客户端返回的URL地址请求

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            //自定义类返回错误
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;

        } else {
            if (config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误。';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }
        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request_url' => $request->url()
        ];
        return json($result, $this->code);
    }

    private function recordErrorLog(\Exception $e){
        Log::record($e->getMessage(), 'error')->save();
    }
}