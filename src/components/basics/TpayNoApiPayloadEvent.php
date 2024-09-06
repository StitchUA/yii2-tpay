<?php

namespace stitchua\tpay\components\basics;

use stitchua\tpay\models\TpayBasicPaymentNotifications;

class TpayNoApiPayloadEvent extends \yii\base\Event
{
    public TpayBasicPaymentNotifications $tpayTransaction;

    public function __construct(TpayBasicPaymentNotifications $tpayTransaction, $config = [])
    {
        $this->tpayTransaction = $tpayTransaction;
        parent::__construct($config);
    }
}