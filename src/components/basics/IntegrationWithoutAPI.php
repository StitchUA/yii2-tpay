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
        'id', 'amount', 'description', 'group', 'resultUrl', 'resultEmail', 'returnUrl', 'returnErrorUrl',
        'email', 'name', 'address', 'city', 'zip', 'country', 'phone', 'language', 'timehash', 'crc',
        'customDescription', 'merchantDescription'
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
            [['email', 'name', 'address', 'merchantDescription'], 'string', 'max' => 64],
            [['city', 'timehash', 'customDescription'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['zip'], 'string', 'max' => 10],
            [['country'], 'string', 'min' => 2, 'max' => 3],
            [['language'], 'in', 'range' => self::$languagies],
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
            if (empty($payload->crc) && !empty($crcData)) {
                $crcData[] = (float)$payload->amount;
                $crcData[] = $payload->fld_id;
                $crcData[] = $this->module->tpayTransactionCrcSalt;
                $payload->crc = md5(implode('', $crcData));
            } else {
                $payload->crc = '';
            }
            $payloadParams = array_intersect_key($payload->attributes, array_flip($this->tpayNoApiParamsNames));

            $payload->md5sum = md5(implode('&', [
                $payload->id,
                $payload->amount,
                $payload->crc,
                $this->module->merchantCode
            ]));
            $payload->updateAttributes(['crc', 'md5sum']);

            $link = $this->panelURL . DIRECTORY_SEPARATOR .'?'. http_build_query(array_filter($payloadParams,
                        function ($val){
                            return !empty($val);
                        }
                    )
                );
        } else {
            Yii::error([
                'MSG' => 'Tpay[Integration without API] error',
                'Errors' => $payload->errors
            ], 'tpay');
            throw new Exception('Payload save error');
        }

        return $link;

    }
}