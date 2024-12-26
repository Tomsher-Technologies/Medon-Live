<?php

namespace App\Utility;

class SendSMSUtility
{
    public static function sendSMS($to, $text)
    {
        $sender = urldecode("MEDON PHY");
        $sms_url = 'http://tomsher.me/sms/smsapi';
        
        // $sender = urlencode("TOMSHER");
        // $sms_url = 'http://tomsher.me/sms/smsapi';
        // R60001345fd4c0b80cb815.29446877
        //C2004570666a7c733bc896.25472466 
        
        $sms_args = array(
            'api_key' => env('SMS_API_KEY', 'C20045706718b3ad5134b3.59179579'),
            'type' => 'text',
            'contacts' => $to,
            'senderid' => $sender,
            'msg' => $text,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $sms_url . "?" . http_build_query($sms_args));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }
       
        curl_close($curl);

        return $result;
        
    
    }
}
