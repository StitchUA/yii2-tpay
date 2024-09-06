<?php

namespace stitchua\tpay;

use tpayLibs\src\_class_tpay\Utilities\Util;
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
     * @var bool Disable validation of Tpay IPs servers
     */
    public $validateServerIP = true;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if(empty($this->merchantId) || empty($this->merchantCode)){
            throw new InvalidConfigException('Invalid configuration of module: '.$this->id);
        }
        Util::$customLogPatch = __DIR__ .DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR;
        Util::$loggingEnabled = false;
        $this->validateServerIP = (bool)$this->validateServerIP;
    }
}
