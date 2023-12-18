<?php

namespace App\Http\Controllers;

use App\Midtrans;
use App\Models\Order;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function index(Request $request){
        $server_key = "SB-Mid-server-znssIwVQbni3L6FBfZBovjbu";
        $is_production = false;
        $api_url = $is_production ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        header('Content-Type: application/json');
        $charge = $this->chargeAPI($api_url, $server_key, $request->all());

        return $charge['body'];
    }

    function chargeAPI($api_url, $server_key, $request_body){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($server_key . ':')
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_body));
        
        $result = array(
            'body' => curl_exec($ch),
            'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        );

        return $result;
        
    }

    public function webhook(Request $request){
        $merchant_id = "G798473603";
        $client_key = "SB-Mid-client-pR3ZkmoavvHGWBbN";
        $server_key = "SB-Mid-server-znssIwVQbni3L6FBfZBovjbu";

        $midtrans = new Midtrans();
        $midtrans->setMerchantId($merchant_id);
        $midtrans->setClientKey($client_key);
        $midtrans->setServerKey($server_key);

        $data_signature = [
            $request->order_id,
            $request->status_code,
            $request->gross_amount,
        ];
        $signature = $request->signature_key;

        $validateSignature = $midtrans->validateSignature($data_signature, $signature);
        if($validateSignature){
            $order_id = $request->order_id;
            $status = $request->status_code;
            $transaction_id = $request->transaction_id;

            $order = Order::where('invoice', $order_id)->first();
            if($order){
                if($status == 200){
                    $order->update([
                        'status' => 4
                    ]);
                    $order->payment?->update([
                        'transaction_id' => $transaction_id,
                        'payment_name' => $request->payment_type,
                    ]);
                } else {

                }
            }
        } else {

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Midtrans notification success'
        ]);
    }
}
