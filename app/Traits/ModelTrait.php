<?php

namespace App\Traits;

use Hashids;

Trait ModelTrait
{
    /**
     * 加密id
     * @param
     * @author		wen.zhou@bioon.com
     * @date		2016-05-12 10:47:11
     * @return
     */
    public function encodeId($connection, $value){
        if(checkEncrypt($connection)){
            return Hashids::connection($connection)->encode($value);
        }else{
            return $value;
        }
    }

    /**
     * 解密id
     * @param  [type] $connection [description]
     * @param  [type] $value      [description]
     * @return [type]             [description]
     */
    public function decodeId($connection, $value){
        if(checkEncrypt($connection)){
            $arr = Hashids::connection($connection)->decode($value);
            return isset($arr[0]) && $arr[0] ? $arr[0] : 0;
        }else{
            return $value;
        }
    }

}