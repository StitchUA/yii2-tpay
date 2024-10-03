<?php

namespace stitchua\tpay\components\basics;

use Exception;
use stitchua\tpay\base\ILinkPayload;
use stitchua\tpay\models\TpayNoApiPayload;
use stitchua\tpay\Tpay;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 *
 * Simple integration of the merchant service with tpay.com is a redirection of the customer to https://secure.tpay.com, along with the parameters required to define the transaction.
 *
 * @link https://docs.tpay.com/?_gl=1*1yovfjp*_gcl_aw*R0NMLjE2ODY4MTAxMDAuQ2p3S0NBand5cVdrQmhCTUVpd0FwMnlVRnZkOEVnSno4RDRTbTBQZUJTbk9SQnlXZDVmazhENE9EcktZeGZ2U3dSdzlzNUl3NnFSZXB4b0NBSndRQXZEX0J3RQ..*_gcl_au*NTAwODI3NTI2LjE2ODQzMDU0Njc.#!/Tpay/tpay_no_api
 */
class IntegrationWithoutAPI extends \yii\base\Model
{
    protected $panelURL = 'https://secure.tpay.com';
    /**
     * @var Tpay
     */
    private $module;

    private $tpayNoApiParamsNames = [
        'id', // Numeric identifier assigned to the merchant during the registration.
        'amount', // Transaction amount with dot as decimal separator.
        'description', // Transaction description
        'crc', // Auxiliary parameter to identify the transaction on the merchant side.
        'md5sum', // The checksum used to verify the parameters received from the merchant.
        'online', // Allow online payments only.
        'group', // Bank group number selected by customer on seller's website.
        'result_url', // The URL address to which the transaction result will be sent via POST method.
        'result_email', // Tpay system will send notifications about transactions to this email.
        'merchant_description', // Description of the seller during the transaction.
        'custom_description', // Optional field used for card transactions made via Acquirer (Elavon).
        'return_url', // The URL to which the client will be redirected after the correct transaction processing.
        'return_error_url', // The URL to which the client will be redirected in case transaction error occurs.
        'language', // Customer language.
        'email', // Customer email.
        'name', // Customer name.
        'address', // Customer address.
        'city', // Customer city.
        'zip', // Customer postal code.
        'country', // Customer country.
        'tax_id', // Customer tax identification number.
        'phone', // Customer telephone number.
        'accept_tos', // Customer acceptance of tpay.com rules.
        'expiration_date', // Maximum transaction payment date.
        'timehash' // Parameter protects expiration_date from unauthorized changes.
    ];

    public function __construct(Tpay $module, $config = [])
    {
        $this->module = $module;
        parent::__construct($config);
        if (empty($this->module->merchantId) || empty($this->module->merchantCode)) {
            throw new InvalidConfigException('Brak wymaganych ustawień.');
        }
    }

    public const LANG_PL = 'PL';
    public const LANG_EN = 'EN';
    public static $languagies = [
        self::LANG_PL, self::LANG_EN
    ];

    public function rules()
    {
        return [
            [['id', 'amount', 'description'], 'required'],
            [['id', 'amount', 'group'], 'numeric'],
            [['description', 'crc'], 'string', 'max' => 128],
            [['resultUrl', 'resultEmail', 'returnUrl', 'returnErrorUrl'], 'string', 'max' => 512],
            [['email', 'name', 'address', 'city', 'merchantDescription','merchant_description'], 'string', 'max' => 64],
            [['city', 'timehash', 'customDescription', 'md5sum', 'custom_description'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['zip'], 'string', 'max' => 10],
            [['country'], 'string', 'min' => 2, 'max' => 3],
            [['language'], 'in', 'range' => self::$languagies],
            ['language', 'string', 'max' => 2],
            [['online', 'accept_tos'], 'in', 'range' => [0, 1]],
            ['tax_id', 'string', 'min' => 3, 'max' => 20],
            ['entity_id', 'string'],
            ['result_email', 'email'],
            [['return_url', 'return_error_url'], 'string', 'max' => 512],
            ['expiration_date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            ['entity_id', 'string'],
        ];
    }

    /**
     * @param ILinkPayload $linkPayload
     * @param TpayNoApiPayload|null $payload
     * @return string
     * @throws Exception
     */
    public function getPaymentLink(ILinkPayload $linkPayload, ?TpayNoApiPayload &$payload): string
    {
        $link = '';
        $payload = new TpayNoApiPayload($linkPayload);
        if (empty($payload->result_url)) {
            $payload->result_url = Yii::$app->urlManager->createAbsoluteUrl(["/{$this->module->id}/basic-payment/ipn"]);
        }

        if ($payload->save()) {
            $crcData = $payload->crcData;
            if(empty($payload->crc)) {
                $payload->crc = '';
                if(!empty($crcData)) {
                    $crcData[] = (float)$payload->amount;
                    $crcData[] = $payload->fld_id;
                    $crcData[] = $this->module->tpayTransactionCrcSalt;
                    $payload->crc = md5(implode('', $crcData));
                }
            }


            $payload->md5sum = md5(implode('&', [
                $payload->id,
                $payload->amount,
                $payload->crc,
                $this->module->merchantCode
            ]));
            $payload->updateAttributes(['crc' => $payload->crc, 'md5sum' => $payload->md5sum]);

            $link = $this->getLink($payload);
        } else {
            Yii::error([
                'MSG' => 'Tpay[Integration without API] error',
                'Errors' => $payload->errors
            ], 'tpay');
            throw new Exception('Payload save error');
        }

        return $link;

    }

    /**
     * You can use this method to generate a payment link from existing payload.
     * It is useful when you want to generate a payment link from the existing payload,
     * especially when you want to use the same payload for multiple payments.
     * For example, your crcData consists seconds metrix, and you don't want to change it for each payment.
     *
     * @param TpayNoApiPayload $payload
     * @return string
     */
    public function getLink(TpayNoApiPayload $payload): string
    {
        $payloadParams = array_intersect_key($payload->attributes, array_flip($this->tpayNoApiParamsNames));

        Yii::debug([
            'MSG' => 'Tpay[Integration without API] params',
            'Payload' => $payloadParams,
            '$payload->attributes' => $payload->attributes
        ], 'tpay');

        $link = $this->panelURL . DIRECTORY_SEPARATOR . '?' . http_build_query(array_filter($payloadParams,
                    function ($val) {
                        return !empty($val);
                    }
                )
            );

        Yii::debug([
            'MSG' => 'Tpay[Integration without API] generated link',
            'Link' => $link,
            'Payload' => $payloadParams,
            '$payload->attributes' => $payload->attributes
        ], 'tpay');
        return $link;
    }
}