<?php
declare (strict_types = 1);

namespace app\admin;

use think\Exception;

abstract class BaseService
{


    function curlXml($url,$xml){
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_VERBOSE, 1);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $xml );
        if (curl_errno($ch)){
            throw new Exception(curl_error($ch));
        }
        $result = curl_exec ( $ch );
        curl_close ( $ch );
        return $result;
    }
}
