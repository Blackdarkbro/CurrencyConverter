<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m230915_025954_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('currency_course_value', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5),
            'value' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // $this->dropTable('currency_course_value');
    }
}
