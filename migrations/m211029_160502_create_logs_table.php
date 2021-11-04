<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%logs}}`.
 */
class m211029_160502_create_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211028_052441_logs cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('logs', [
            'id'                       => $this->bigPrimaryKey()->unsigned(),
            'endpoint'                 => $this->string(512)->notNull()->defaultValue(''),
            'okada_endpoint'           => $this->string(512)->notNull()->defaultValue(''),
            'incoming_params'          => $this->string(),
            'okada_response'           => $this->string(),
            'response'                 => $this->string(),
            'incoming_timestamp'       => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP()'),
            'okada_response_timestamp' => $this->dateTime(),
            'response_timestamp'       => $this->dateTime(),
            'ip_address'               => $this->string(64),
        ]);
    }

    public function down()
    {
        $this->dropTable('logs');
    }
}
