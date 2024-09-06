<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tpay_basic_payment_notifications}}`.
 */
class m230620_102354_create_tpay_basic_payment_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tpay_basic_payment_notifications}}', [
            'fld_id' => $this->primaryKey(),
            'id' => $this->string()->comment('Merchant ID'),
            'tr_id' => $this->string()->comment('Transaction title assigned by the Tpay system.'),
            'tr_date' => $this->string()->comment('Transaction creation date.'),
            'tr_crc' => $this->string()->comment('This parameter will contain the exact value passed with create transaction request from your system. You should use it to identify the order ID on your side.'),
            'tr_amount' => $this->string()->comment('Transaction target amount.'),
            'tr_paid' => $this->string()->comment('Real amount paid by a customer. Note: depending on your account settings, this value may be different than transaction amount!'),
            'tr_desc' => $this->string()->comment('Transaction description.'),
            'tr_status' => $this->string()->comment('The successful payment notification will contain word "TRUE". Notification about manual full amount chargeback made from Merchant Panel will contain word "CHARGEBACK".
Note: depending on account settings, transaction status might be correct when the amount paid is different than transaction amount!
E.g. seller accepts overpayments.'),
            'tr_error' => $this->string()->comment('Error information parameter. Its values can be as follows:
• none – no error,
• overpay – overpayment,
• surcharge – underpayment.
Note: this parameter might be different than "none" even when transaction status is TRUE. E.g. when there is an overpayment then tr_status=TRUE and tr_error=overpay.'),
            'tr_email' => $this->string()->comment('Customer email address'),
            'md5sum' => $this->string()->comment('The checksum used to verify the parameters sent to the merchant. This checksum should always be verified on the merchant\'s side and data discarded in case of conflict.
    When seller\'s verification code is not set, its value is assumed to be an empty string. '),
            'test_mode' => $this->string()->comment('Parameter informs if a transaction was created in test or normal mode:
"1" – test transaction
"0" – normal transaction '),
            'wallet' => $this->string()->comment('This parameter present only when payment was made by MasterPass channel
Contains value: "masterpass" '),
            'masterpass' => $this->string()->comment('This parameter present only when payment was made by MasterPass channel
Contains value: "1" ')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tpay_basic_payment_notifications}}');
    }
}
