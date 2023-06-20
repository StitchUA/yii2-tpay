<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tpay_no_api_trunsactions}}`.
 */
class m230620_044250_create_tpay_no_api_payload_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tpay_no_api_payload}}', [
            'fld_id' => $this->primaryKey()->unsigned()->comment('Primary key'),
            'id' => $this->integer()->unsigned()->comment('Merchant ID'),
            'amount' => $this->decimal(12, 4),
            'description' => $this->string(128),
            'crc' => $this->string(128),
            'md5sum' => $this->string(32),
            'online' => $this->integer(1)->unsigned(),
            'group' => $this->integer()->unsigned(),
            'result_url' => $this->string(512),
            'result_email' => $this->string(512),
            'merchant_description' => $this->string(64),
            'custom_description' => $this->string(32),
            'return_url' => $this->string(512),
            'return_error_url' => $this->string(512),
            'language' => $this->string(2),
            'email' => $this->string(64),
            'name' => $this->string(64),
            'address' => $this->string(64),
            'city' => $this->string(32),
            'zip' => $this->string(10),
            'country' => $this->string(3),
            'phone' => $this->string(16),
            'accept_tos' => $this->integer(1),
            'expiration_date' => $this->dateTime(),
            'timehash' => $this->string(32),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tpay_no_api_payload}}');
    }
}
