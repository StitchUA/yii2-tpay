<?php

namespace stitchua\tpay\models;

use Yii;

/**
 * This is the model class for table "tbl_tpay_basic_payment_notifications".
 *
 * @property int $fld_id
 * @property string|null $id Merchant ID
 * @property string|null $tr_id Transaction title assigned by the Tpay system.
 * @property string|null $tr_date Transaction creation date.
 * @property string|null $tr_crc This parameter will contain the exact value passed with create transaction request from your system. You should use it to identify the order ID on your side.
 * @property string|null $tr_amount Transaction target amount.
 * @property string|null $tr_paid Real amount paid by a customer. Note: depending on your account settings, this value may be different than transaction amount!
 * @property string|null $tr_desc Transaction description.
 * @property string|null $tr_status The successful payment notification will contain word "TRUE". Notification about manual full amount chargeback made from Merchant Panel will contain word "CHARGEBACK". Note: depending on account settings, transaction status might be correct when the amount paid is different than transaction amount! E.g. seller accepts overpayments.
 * @property string|null $tr_error Error information parameter. Its values can be as follows: • none – no error, • overpay – overpayment, • surcharge – underpayment. Note: this parameter might be different than "none" even when transaction status is TRUE. E.g. when there is an overpayment then tr_status=TRUE and tr_error=overpay.
 * @property string|null $tr_email Customer email address
 * @property string|null $md5sum The checksum used to verify the parameters sent to the merchant. This checksum should always be verified on the merchant's side and data discarded in case of conflict.     When seller's verification code is not set, its value is assumed to be an empty string. 
 * @property string|null $test_mode Parameter informs if a transaction was created in test or normal mode: "1" – test transaction "0" – normal transaction 
 * @property string|null $wallet This parameter present only when payment was made by MasterPass channel Contains value: "masterpass" 
 * @property string|null $masterpass This parameter present only when payment was made by MasterPass channel Contains value: "1" 
 */
class TpayBasicPaymentNotifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tpay_basic_payment_notifications}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tr_id', 'tr_date', 'tr_crc', 'tr_amount', 'tr_paid', 'tr_desc', 'tr_status', 'tr_error', 'tr_email', 'md5sum', 'test_mode', 'wallet', 'masterpass'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fld_id' => Yii::t('partner_activity', 'Fld ID'),
            'id' => Yii::t('partner_activity', 'Merchant ID'),
            'tr_id' => Yii::t('partner_activity', 'Transaction title assigned by the Tpay system.'),
            'tr_date' => Yii::t('partner_activity', 'Transaction creation date.'),
            'tr_crc' => Yii::t('partner_activity', 'This parameter will contain the exact value passed with create transaction request from your system. You should use it to identify the order ID on your side.'),
            'tr_amount' => Yii::t('partner_activity', 'Transaction target amount.'),
            'tr_paid' => Yii::t('partner_activity', 'Real amount paid by a customer. Note: depending on your account settings, this value may be different than transaction amount!'),
            'tr_desc' => Yii::t('partner_activity', 'Transaction description.'),
            'tr_status' => Yii::t('partner_activity', 'The successful payment notification will contain word \"TRUE\". Notification about manual full amount chargeback made from Merchant Panel will contain word \"CHARGEBACK\".
Note: depending on account settings, transaction status might be correct when the amount paid is different than transaction amount!
E.g. seller accepts overpayments.'),
            'tr_error' => Yii::t('partner_activity', 'Error information parameter. Its values can be as follows:
• none – no error,
• overpay – overpayment,
• surcharge – underpayment.
Note: this parameter might be different than \"none\" even when transaction status is TRUE. E.g. when there is an overpayment then tr_status=TRUE and tr_error=overpay.'),
            'tr_email' => Yii::t('partner_activity', 'Customer email address'),
            'md5sum' => Yii::t('partner_activity', 'The checksum used to verify the parameters sent to the merchant. This checksum should always be verified on the merchant\'s side and data discarded in case of conflict.
    When seller\'s verification code is not set, its value is assumed to be an empty string. '),
            'test_mode' => Yii::t('partner_activity', 'Parameter informs if a transaction was created in test or normal mode:
\"1\" – test transaction
\"0\" – normal transaction '),
            'wallet' => Yii::t('partner_activity', 'This parameter present only when payment was made by MasterPass channel
Contains value: \"masterpass\" '),
            'masterpass' => Yii::t('partner_activity', 'This parameter present only when payment was made by MasterPass channel
Contains value: \"1\" '),
        ];
    }
}
