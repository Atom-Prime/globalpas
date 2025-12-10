<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m251210_152316_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'autor_id' => $this->integer()->notNull(),
            'pages' => $this->integer(),
            'language' => $this->string(50),
            'genre' => $this->string(100),
            'description' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // FK
        $this->addForeignKey(
            'fk_book_autor',
            '{{%book}}',
            'autor_id',
            '{{%autor}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_book_autor', '{{%book}}');
        $this->dropTable('{{%book}}');
    }
}
