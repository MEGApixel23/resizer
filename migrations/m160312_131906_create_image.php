<?php

use yii\db\Migration;

class m160312_131906_create_image extends Migration
{
    public function up()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(null),
            'width' => $this->integer()->notNull(),
            'height' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
            'created_at' => $this->integer(10)->defaultValue(null),
            'updated_at' => $this->integer(10)->defaultValue(null),
        ]);

        $this->createIndex('image_filename', 'image', 'filename', true);
        $this->addForeignKey(
            'fk_image_user',
            'image', 'user_id',
            'user', 'id',
            'SET NULL', 'SET NULL'
        );
    }

    public function down()
    {
        $this->dropTable('image');
    }
}
