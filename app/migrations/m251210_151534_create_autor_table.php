<?php

use yii\db\Migration;

class m251210_151534_create_autor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autor}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'birth_year' => $this->integer(),
            'country' => $this->string(100),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autor}}');
    }
}
