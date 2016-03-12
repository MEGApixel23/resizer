<?php

use yii\db\Migration;

class m160312_131605_create_device extends Migration
{
    public function up()
    {
        $this->createTable('device', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'created_at' => $this->integer(10)->defaultValue(null),
            'updated_at' => $this->integer(10)->defaultValue(null),
        ]);
        $this->createIndex('device_token', 'device', 'token', true);
        $this->addForeignKey(
            'fk_device_user',
            'device', 'user_id',
            'user', 'id',
            'CASCADE', 'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('device');
    }
}
