<?php

namespace stitchua\tpay\components\basics;

use stitchua\tpay\models\TpayBasicPaymentNotifications;
use stitchua\tpay\models\TpayNoApiPayload;
use stitchua\tpay\Tpay;
use Yii;

class BasicNotificationHandler extends \tpayLibs\src\_class_tpay\Notifications\BasicNotificationHandler
{
    private $module;
    public function __construct(Tpay $module)
    {
        $this->module = $module;
        $this->merchantId = $module->merchantId;
        $this->merchantSecret = $module->merchantCode;
        $this->validateServerIP = $module->validateServerIP;
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
                    $payload->trigger(TpayNoApiPayload::EVENT_PAID,
                        new TpayNoApiPayloadEvent($notification)
                    );
                } else {
                    Yii::error([
                        'MSG' => 'Errors during saving Tpay notification w CRC: '.$payloadCrc,
                        '$payload' => $payload,
                        '$newNotification' => $newNotification,
                        '$_POST' => $_POST
                    ], 'tpay');
                }
            }
        } else {
            Yii::error([
                'MSG' => 'Unknown CRC transaction: '.$payloadCrc,
                '$_POST' => $_POST
            ], 'tpay');
        }
    }

}