<?php

use yii\db\Migration;

class m170526_171434_create_table_ingr extends Migration
{
    public function up()
    {
        $this->createTable('ingr', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'desc' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('ingr');
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
