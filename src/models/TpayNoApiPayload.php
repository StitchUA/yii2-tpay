<?php
namespace stitchua\tpay\models;

use stitchua\tpay\base\ILinkPayload;
use stitchua\tpay\Tpay;
use Yii;

/**
 * This is the model class for table "tbl_tpay_no_api_payload".
 *
 * @property int $fld_id
 * @property int|null $id Merchant ID
 * @property float|null $amount
 * @property string|null $description
 * @property string|null $crc
 * @property string|null $md5sum
 * @property int|null $online
 * @property int|null $group
 * @property string|null $result_url
 * @property string|null $result_email
 * @property string|null $merchant_description
 * @property string|null $custom_description
 * @property string|null $return_url
 * @property string|null $return_error_url
 * @property string|null $language
 * @property string|null $email
 * @property string|null $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $zip
 * @property string|null $country
 * @property string|null $phone
 * @property int|null $accept_tos
 * @property string|null $expiration_date
 * @property string|null $timehash
 */
class TpayNoApiPayload extends \yii\db\ActiveRecord
{

    /** @var string Triggered when Tpay notify about success transaction */
    public const EVENT_PAID = 'payload_paid';
    public $crcData = [];
    public function __construct(?ILinkPayload $payload = null, $config = [])
    {
        if($payload){
            $this->id = $payload->getId();
            $this->amount = $payload->getAmount();
            $this->description = $payload->getDescription();
            $this->crc = $payload->getCrc();
            $this->md5sum = $payload->getMd5sum();
            $this->online = $payload->getOnline();
            $this->group = $payload->getGroup();
            $this->result_url = $payload->getResultUrl();
            $this->result_email = $payload->getResultEmail();
            $this->merchant_description = $payload->getMerchantDescription();
            $this->custom_description = $payload->getCustomDescription();
            $this->return_url = $payload->getReturnUrl();
            $this->return_error_url = $payload->getReturnErrorUrl();
            $this->language = $payload->getLanguage();
            $this->email = $payload->getEmail();
            $this->name = $payload->getName();
            $this->address = $payload->getAddress();
            $this->city = $payload->getCity();
            $this->zip = $payload->getZip();
            $this->country = $payload->getCountry();
            $this->phone = $payload->getPhone();
            $this->accept_tos = $payload->getAcceptTos();
            $this->expiration_date = $payload->getExpirationDate();
            $this->timehash = $payload->getTimehash();
            $this->crcData = $payload->getCrcData();
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tpay_no_api_payload}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'online', 'group', 'accept_tos'], 'integer'],
            [['amount'], 'number'],
            [['expiration_date'], 'safe'],
            [['description', 'crc'], 'string', 'max' => 128],
            [['md5sum', 'custom_description', 'city', 'timehash'], 'string', 'max' => 32],
            [['result_url', 'result_email', 'return_url', 'return_error_url'], 'string', 'max' => 512],
            [['merchant_description', 'email', 'name', 'address'], 'string', 'max' => 64],
            [['language'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 10],
            [['country'], 'string', 'max' => 3],
            [['phone'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('partner_activity', 'ID'),
            'merchant_id' => Yii::t('partner_activity', 'Merchant ID'),
            'amount' => Yii::t('partner_activity', 'Amount'),
            'description' => Yii::t('partner_activity', 'Description'),
            'crc' => Yii::t('partner_activity', 'Crc'),
            'md5sum' => Yii::t('partner_activity', 'Md5sum'),
            'online' => Yii::t('partner_activity', 'Online'),
            'group' => Yii::t('partner_activity', 'Group'),
            'result_url' => Yii::t('partner_activity', 'Result Url'),
            'result_email' => Yii::t('partner_activity', 'Result Email'),
            'merchant_description' => Yii::t('partner_activity', 'Merchant Description'),
            'custom_description' => Yii::t('partner_activity', 'Custom Description'),
            'return_url' => Yii::t('partner_activity', 'Return Url'),
            'return_error_url' => Yii::t('partner_activity', 'Return Error Url'),
            'language' => Yii::t('partner_activity', 'Language'),
            'email' => Yii::t('partner_activity', 'Email'),
            'name' => Yii::t('partner_activity', 'Name'),
            'address' => Yii::t('partner_activity', 'Address'),
            'city' => Yii::t('partner_activity', 'City'),
            'zip' => Yii::t('partner_activity', 'Zip'),
            'country' => Yii::t('partner_activity', 'Country'),
            'phone' => Yii::t('partner_activity', 'Phone'),
            'accept_tos' => Yii::t('partner_activity', 'Accept Tos'),
            'expiration_date' => Yii::t('partner_activity', 'Expiration Date'),
            'timehash' => Yii::t('partner_activity', 'Timehash'),
        ];
    }
}
