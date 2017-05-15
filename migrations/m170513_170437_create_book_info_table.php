<?php

use yii\db\Migration;

/**
 * Handles the creation of table `book_info`.
 */
class m170513_170437_create_book_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'contact_name' => $this->string(100)->notNull(),
            'contact_surname' => $this->string(),
            'contact_patronymic' => $this->string(),
            'address' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex(
            'idx-book_info-user_id',
            '{{%book_info}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%book_info}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-user-user_id',
            '{{%book_info}}'
        );

        $this->dropIndex(
            'idx-book_info-user_id',
            '{{%phone}}'
        );

        $this->dropTable('{{%book_info}}');
    }
}
