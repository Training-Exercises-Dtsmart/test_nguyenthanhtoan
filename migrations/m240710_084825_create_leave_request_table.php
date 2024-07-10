<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%leave_request}}`.
 */
class m240710_084825_create_leave_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%leave_request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'start_date' => $this->date(),
            'end_date' => $this->date(),
            'reason' => $this->string(),
            'status' => $this->string(50)->notNull()->defaultValue('pending'), // 'pending', 'approved', 'disapproved'
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        // Add foreign key for user_id
        $this->addForeignKey(
            'fk-leave_request-user_id',
            'leave_request',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-leave_request-user_id',
            '{{%leave_request}}'
        );
        $this->dropTable('{{%leave_request}}');
    }
}
