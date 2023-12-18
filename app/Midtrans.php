<?php

namespace App;

use Illuminate\Support\Facades\Log;

class Midtrans {
    private $merchant_id;
    private $client_key;
    private $server_key;

    private $url = "https://app.sandbox.midtrans.com"; //Sandbox
    function setMerchantId($merchant_id){
        $this->merchant_id = $merchant_id;
    }

    function setClientKey($client_key){
        $this->client_key = $client_key;
    }

    function setServerKey($server_key){
        $this->server_key = $server_key;
    }

    public function validateSignature($data, $signature){
        $string = "";
        foreach($data as $key => $value){
            if($key != 'signature_key'){
                $string .= urldecode($value);
            }
        }
        $string .= $this->server_key;

        $hash = hash("sha512", $string);
        
        return $hash == $signature;
    }
}