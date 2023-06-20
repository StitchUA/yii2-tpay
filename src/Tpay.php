<?php

namespace stitchua\tpay;

use yii\base\InvalidConfigException;

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
    public $merchantCode = null;
    public $tpayTransactionCrcSalt = 'zsdfasdf78asf6asd8f87';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if(empty($this->merchantId) || empty($this->merchantCode)){
            throw new InvalidConfigException('Zła konfiguracja modułu: '.$this->id);
        }
    }
}
