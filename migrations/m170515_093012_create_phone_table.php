<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phone`.
 */
class m170515_093012_create_phone_table extends Migration
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

        $this->createTable('{{%phone}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(20),
            'book_id' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createIndex(
            'idx-phone-book_id',
            '{{%phone}}',
            'book_id'
        );

        $this->addForeignKey(
            'fk-book_info-book_id',
            '{{%phone}}',
            'book_id',
            '{{%book_info}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-phone-phone-book_id',
            '{{%phone}}',
            'phone,book_id',
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-book_info-book_id',
            '{{%phone}}'
        );


        $this->dropIndex(
            'idx-phone-book_id',
            '{{%phone}}'
        );

        $this->dropIndex(
            'idx-phone-phone-book_id',
            '{{%phone}}'
        );

        $this->dropTable('{{%phone}}');
    }
}
