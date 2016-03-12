<?php

use yii\db\Migration;

class m160312_131450_create_user extends Migration
{
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(10)->defaultValue(null),
            'updated_at' => $this->integer(10)->defaultValue(null),
        ]);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
