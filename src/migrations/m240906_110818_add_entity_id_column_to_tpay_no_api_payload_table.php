<?php

namespace stitchua\tpay\migrations;

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tpay_no_api_payload}}`.
 */
class m240906_110818_add_entity_id_column_to_tpay_no_api_payload_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tpay_no_api_payload}}', 'entity_id', $this->string()->after('fld_id')->comment('Entity which was paid for'));
        $this->createIndex('idx-tpay_no_api_payload-entity_id', '{{%tpay_no_api_payload}}', 'entity_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-tpay_no_api_payload-entity_id', '{{%tpay_no_api_payload}}');
        $this->dropColumn('{{%tpay_no_api_payload}}', 'entity_id');
    }
}
