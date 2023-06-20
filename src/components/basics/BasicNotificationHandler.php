<?php

namespace stitchua\components\basics;

use stitchua\models\TpayBasicPaymentNotifications;
use stitchua\models\TpayNoApiPayload;
use stitchua\tpay\Tpay;

class BasicNotificationHandler extends \tpayLibs\src\_class_tpay\Notifications\BasicNotificationHandler
{
    private $module;
    public function __construct(Tpay $module)
    {
        $this->module = $module;
        $this->merchantId = $module->merchantId;
        $this->merchantSecret = $module->merchantCode;
        parent::__construct();
    }

    public function getTpayNotification()
    {
        $notificationData = $this->checkPayment();
        $payloadCrc = $notificationData['tr_crc'];
        $payload = TpayNoApiPayload::findOne(['crc' => $payloadCrc]);
        if($payload){
            $notification = TpayBasicPaymentNotifications::findOne(['tr_id' => $notificationData['tr_id']]);
            if(!$notification){
                $newNotification = new TpayBasicPaymentNotifications();
                $newNotification->setAttributes($notificationData);
                if($newNotification->save()){

                }
            }
        }
    }

}