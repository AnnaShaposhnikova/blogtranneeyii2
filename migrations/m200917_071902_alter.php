<?php

use yii\db\Migration;

/**
 * Class m200917_071902_alter
 */
class m200917_071902_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('bl_posts','user_id',$this->integer()->unsigned()->notNull()->after('is_release'));
        $this->addColumn('bl_posts','created_at',$this->timestamp()->notNull());
        $this->addColumn('bl_posts','updated_at',$this->timestamp()->null());
        $this->addColumn('bl_posts','deleted_at',$this->timestamp()->null());
        $this->createIndex('user_id','bl_posts',['user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
     $this->dropColumn('posts','user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_071902_alter cannot be reverted.\n";

        return false;
    }
    */
}
