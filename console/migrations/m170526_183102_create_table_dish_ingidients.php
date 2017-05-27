<?php

use yii\db\Migration;

class m170526_183102_create_table_dish_ingidients extends Migration {

    public function up() {
        $this->createTable('dish_ingr', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'ingr_id' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-ingr_to_dish',
            'dish_ingr',
            'ingr_id',
            'ingr',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-dish_to_dish',
            'dish_ingr',
            'dish_id',
            'dish',
            'id',
            'CASCADE'
        );
    }

    public function down() {
        $this->dropTable('dish_ingr');
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
