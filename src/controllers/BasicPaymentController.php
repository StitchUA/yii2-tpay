<?php

namespace stitchua\tpay\controllers;

use stitchua\tpay\components\basics\BasicNotificationHandler;
use yii\web\Controller;

/**
 * Default controller for the `tpay` module
 */
class BasicPaymentController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIpn()
    {
        $notification = (new BasicNotificationHandler())->getTpayNotification();
        $payloadCrc = $notification['tr_crc'];

        return $this->render('index');
    }
}
