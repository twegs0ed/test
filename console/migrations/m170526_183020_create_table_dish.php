<?php

use yii\db\Migration;

class m170526_183020_create_table_dish extends Migration {

    public function up() {
        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'desc' => $this->text(),
        ]);
    }

    public function down() {
        $this->dropTable('dish');
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
