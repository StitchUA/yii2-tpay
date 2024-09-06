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
    public function beforeAction($action)
    {
        if($action->id === 'ipn'){
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIpn()
    {
        $module = Yii::$app->getModule('tpay');
        (new BasicNotificationHandler($module))->getTpayNotification();
        Yii::$app->end();
    }
}
