<?php

namespace stitchua\tpay;

/**
 * tpay module definition class
 */
class Tpay extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'stitchua\tpay\controllers';

    /** @var string|null  ID klienta z panelu Tpay*/
    public $merchantId = null;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
