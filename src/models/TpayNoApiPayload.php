<?php
namespace stitchua\tpay\models;

use stitchua\tpay\base\ILinkPayload;
use stitchua\tpay\Tpay;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_tpay_no_api_payload".
 *
 * @property int $fld_id
 * @property int $entity_id Entity which was paid for
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
 *
 * @property ActiveRecord $entity The entity which was paid for. Make sense if attribute $entity_id is set to fully qualified class name.
 */
class TpayNoApiPayload extends \yii\db\ActiveRecord
{

    /** @var string Triggered when Tpay notify about success transaction */
    public const EVENT_PAID = 'payload_paid';
    public $crcData = [];

    /**
     * @var string Primary key name of entity_id object which was paid for
     */
    public $crc_name = 'fld_payment_crc';

    public function __construct(?ILinkPayload $payload = null, $config = [])
    {
        if($payload){
            $this->entity_id = $payload->getEntityId();
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
            [['entity_id'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'entity_id' => Yii::t('yii2_tpay', 'Entity ID'),
            'id' => Yii::t('yii2_tpay', 'ID'),
            'merchant_id' => Yii::t('yii2_tpay', 'Merchant ID'),
            'amount' => Yii::t('yii2_tpay', 'Amount'),
            'description' => Yii::t('yii2_tpay', 'Description'),
            'crc' => Yii::t('yii2_tpay', 'Crc'),
            'md5sum' => Yii::t('yii2_tpay', 'Md5sum'),
            'online' => Yii::t('yii2_tpay', 'Online'),
            'group' => Yii::t('yii2_tpay', 'Group'),
            'result_url' => Yii::t('yii2_tpay', 'Result Url'),
            'result_email' => Yii::t('yii2_tpay', 'Result Email'),
            'merchant_description' => Yii::t('yii2_tpay', 'Merchant Description'),
            'custom_description' => Yii::t('yii2_tpay', 'Custom Description'),
            'return_url' => Yii::t('yii2_tpay', 'Return Url'),
            'return_error_url' => Yii::t('yii2_tpay', 'Return Error Url'),
            'language' => Yii::t('yii2_tpay', 'Language'),
            'email' => Yii::t('yii2_tpay', 'Email'),
            'name' => Yii::t('yii2_tpay', 'Name'),
            'address' => Yii::t('yii2_tpay', 'Address'),
            'city' => Yii::t('yii2_tpay', 'City'),
            'zip' => Yii::t('yii2_tpay', 'Zip'),
            'country' => Yii::t('yii2_tpay', 'Country'),
            'phone' => Yii::t('yii2_tpay', 'Phone'),
            'accept_tos' => Yii::t('yii2_tpay', 'Accept Tos'),
            'expiration_date' => Yii::t('yii2_tpay', 'Expiration Date'),
            'timehash' => Yii::t('yii2_tpay', 'Timehash'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne($this->entity_id, [$this->crc_name => 'crc']);
    }
}
