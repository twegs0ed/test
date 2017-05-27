<?php

use yii\db\Migration;

class m170526_172810_create_column_active_to_ingr extends Migration
{
    public function up()
    {
        $this->addColumn('ingr', 'active', 'ENUM("yes", "no") NOT NULL DEFAULT "yes"');
    }

    public function down()
    {
        echo "m170526_172810_create_column_active_to_ingr cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
