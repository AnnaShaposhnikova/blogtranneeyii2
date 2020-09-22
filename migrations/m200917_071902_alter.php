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
        $this->addColumn('bl_posts','user_id',$this->integer()->unsigned()->defaultValue(null)->after('is_release'));
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
