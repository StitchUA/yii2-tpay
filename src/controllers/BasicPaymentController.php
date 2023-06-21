<?php

namespace stitchua\tpay\controllers;

use stitchua\tpay\components\basics\BasicNotificationHandler;
use Yii;
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
        $module = Yii::$app->getModule('tpay');
        $notification = (new BasicNotificationHandler($module))->getTpayNotification();
        $payloadCrc = $notification['tr_crc'];
        Yii::$app->end();
    }
}
