<?php

use yii\db\Migration;

/**
 * Class m200917_090912_alter_users_table
 */
class m200917_090912_alter_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('users','role',$this->integer()->unsigned()->notNull()->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
       $this->dropColumn('users', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200917_090912_alter_users_table cannot be reverted.\n";

        return false;
    }
    */
}
