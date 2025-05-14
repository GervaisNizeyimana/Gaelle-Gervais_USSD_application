<?php
require 'vendor/autoload.php';


use AfricasTalking\SDK\AfricasTalking;

class sms {
    protected $phone;
    protected $AT;

    function __construct($phone) {
        // Initialize Africa's Talking gateway with correct credentials
        $this->phone = $phone;
        $this->AT = new AfricasTalking('sandbox', 'atsk_a746364f6190b8fe200dbe2d1c762254b9ddb51a117114094b689d8d3f380a67da00894d');
    }

    public function sendSMS($message, $recipients) {
        $sms = $this->AT->sms();

        try {
            // Don't include 'from' in sandbox
            $result = $sms->send([
                'to'      => $recipients,
                'message' => $message
            ]);
            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
// $phone="+250786139330";
// $recipient="+250789239839";
// $message="Water from Nizeyimana";

// $sms= new sms($phone);
// $sent = $sms->sendSMS($message,$recipient);
// // print_r($sent);

?>
