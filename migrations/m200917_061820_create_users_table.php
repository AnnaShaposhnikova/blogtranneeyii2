<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m200917_061820_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'first_name' =>$this->string('255')->notNull(),
            'last_name'=>$this->string('255')->notNull(),
            'email'=> $this->string(255)->notNull()->unique(),
            'password'=>$this->string(255)->notNull(),
            'created_at'=>$this->timestamp()->defaultValue(null)->null(),
            'updated_at' =>$this->timestamp()->defaultValue(null)->null(),
            'deleted_at' =>$this->timestamp()->defaultValue(null)->null()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
